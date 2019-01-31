<?php
/**
 * Created by PhpStorm.
 * User: lsp
 * Date: 2019-01-23
 * Time: 16:36
 */

namespace app\service;


use app\lib\exception\OrderException;
use app\lib\exception\UserException;
use app\model\OrderProduct;
use app\model\Product;
use app\model\UserAddress;
use think\Db;
use think\Exception;
use app\model\Order as orderModel;
use app\model\OrderProduct as orderProductModel;

class Order
{
    protected $oProducts;
    protected $products;
    protected $uid;
    function __construct()
    {
    }
    public function place($uid,$oProducts){
        $this->oProducts = $oProducts;
        $this->uid = $uid;
        $this->products =$this->getProductsByOrder($oProducts);
        $status = $this->getOrderStatus();
        if(!$status["pass"]){
            $status["order_id"] = -1;
            return $status;
        }
        $orderSnap =$this->snapOrder();
        $status = self::createOrderByTrans($orderSnap);
        $status["pass"] =true;
        return $status;
    }

    public function getProductsByOrder($oProducts){
        $oPIDs =array();
        foreach ($oProducts as $item){
            array_push($oPIDs,$item["product_id"]);
        }
        $products = Product::getProductsByIds($oPIDs);
        return $products;
    }

    public function getOrderStatus(){
        $status =[
            "pass" =>true,
            "orderPrice" =>0,
            "pStatusArray" =>[]
        ];
        foreach ($this->oProducts as $oProduct){
            $pStatus = $this->getProductStatus($oProduct["product_id"],$oProduct["count"],$this->products);
            if(!$pStatus["haveStock"]){
                $status["pass"]=false;
            }
            $status["orderPrice"]+= $pStatus["totalPrice"];
            array_push($status["pStatusArray"],$pStatus);
        }
        return $status;
    }

    public function getProductStatus($oPID,$oCount,$products){
        $pIndex = -1;
        $pStatus =[
            "id" =>null,
            "haveStock" =>false,
            "count" =>0,
            "name" =>"",
            "totalPrice" =>0
        ];
        for ($i =0;$i<count($products);$i++){
            if($oPID ==$products[$i]["id"]){
                $pIndex =$i;
            }
        }
        if($pIndex == -1){
            throw new OrderException([
                "msg" =>"id为".$oPID."的商品不存在，订单创建失败！"
            ]);
        }else{
            $product = $products[$pIndex];
            $pStatus["id"] =$product["id"];
            $pStatus["name"]=$product["name"];
            $pStatus["count"]=$oCount;
            $pStatus["totalPrice"]=$oCount*$product["price"];
            if($product["stock"] - $oCount >=0){
                $pStatus["haveStock"] =true;
            }
        }
        return $pStatus;
    }

    public function getUserAddress(){
        $address =UserAddress::getAddressByUid($this->uid);
        if(!$address){
            throw new UserException([
                "msg" =>"用户收货地址不存在，下单失败",
                 "errorCode" =>60001
                ]);
        }
        return $address->toArray();
    }

    public function snapOrder(){
        $snap =[
            "orderPrice" =>0,
            "totalCount" =>0,
            "pStatus" =>[],
            "snapAddress" =>json_encode($this->getUserAddress()),
            "snapName" =>$this->products[0]["name"],
            "snapImag" =>$this->products[0]["main_img_url"]
        ];
        if(count($this->oProducts)>1){
            $snap["snapName"].="......";
        }
        for ($i=0;$i<count($this->oProducts);$i++){
            $eqlIndex =-1;
            for ($k=0;$k<count($this->products);$k++){
                if($this->oProducts[$i]["product_id"]==$this->products[$k]["id"]){
                    $eqlIndex =$k;
                    break;
                }
            }
            if($eqlIndex==-1){
                throw new OrderException([
                    "msg" =>"id为".$this->oProducts[$i]["product_id"]."的商品不存在，订单创建失败！"
                ]);
            }
            $oProduct = $this->oProducts[$i];
            $product =$this->products[$eqlIndex];
            $pStatus =$this->snapProduct($product,$oProduct["count"]);
            $snap["orderPrice"] +=$pStatus["totalPrice"];
            $snap["totalCount"] +=$pStatus["count"];
            array_push($snap["pStatus"],$pStatus);
        }
        return $snap;
    }

    public function snapProduct($product,$oCount){
        $pStatus =[
            "id" =>null,
            "name" =>null,
            "main_img_url" =>null,
            "count" =>$oCount,
            "totalPrice" =>0,
            "price" =>0
        ];
        $pStatus["id"] =$product["id"];
        $pStatus["name"] =$product["name"];
        $pStatus["main_img_url"] =$product["main_img_url"];
        $pStatus["totalPrice"] =$oCount*$product["price"];
        $pStatus["price"] =$product["price"];
        return $pStatus;
    }

    public function createOrderByTrans($orderSnap){
        Db::startTrans();
        try{
            $orderArr=[
                "order_no" =>$this->makeOrderNo(),
                "user_id" =>$this->uid,
                "total_price" =>$orderSnap["orderPrice"],
                "total_count" =>$orderSnap["totalCount"],
                "snap_img" =>$orderSnap["snapImag"],
                "snap_name" =>$orderSnap["snapName"],
                "snap_items" =>json_encode($orderSnap["pStatus"]),
                "snap_address" =>$orderSnap["snapAddress"]
            ];
            $order=orderModel::saveOrder($orderArr);
            $order_id =$order->id;
            $create_time =$order->create_time;

            foreach ($this->oProducts as &$p){
                $p["order_id"] =$order_id;
            }
            orderProductModel::insertOrderProduct($this->oProducts);
            Db::commit();
            return [
                "order_no" =>$orderArr["order_no"],
                "order_id" =>$order_id,
                "create_time" =>$create_time            //时间不对
            ];
        }catch (Exception $exception){
            Db::rollback();
            throw  $exception;
        }
    }
    public function makeOrderNo(){
        $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
        $orderSn =
            $yCode[intval(date('Y')) - 2017] . strtoupper(dechex(date('m'))) . date(
                'd') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf(
                '%02d', rand(0, 99));
        return $orderSn;
    }
    public function checkOrderStock($orderID){
        $this->oProducts =OrderProduct::getoProductById($orderID);
        $this->products =$this->getProductsByOrder($this->oProducts);
        $status =$this->getOrderStatus();
        return $status;
    }


}