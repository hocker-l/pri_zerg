<?php
/**
 * Created by PhpStorm.
 * User: lsp
 * Date: 2019-01-28
 * Time: 15:28
 */

namespace app\service;


use app\lib\exception\OrderException;
use app\lib\exception\PayException;
use app\lib\exception\TokenException;
use app\model\Order as orderModel;
use think\Loader;
use think\Log;
use app\model\Order;

Loader::import("WxPay.WxPay",EXTEND_PATH,".Api.php");


class Pay
{
    protected $orderID;
    protected $orderNo;
    function __construct($orderID)
    {
        if(!$orderID){
            throw new PayException(
                ["msg" =>"订单号不能为空！"]
            );
        }
        $this->orderID =$orderID;
    }

    public function pay(){
        $this->checkOrderValid();
        $order =new Order();
        $status =$order->checkOrderStock($this->orderID);
        if(!$status["pass"]){
            return $status;
        }
        return $this->makeWxPreOrder($status['orderPrice']);

    }
    private function checkOrderValid(){
        $order =orderModel::getOrderByID($this->orderID);
        if(!$order){
            throw  new OrderException();
        }
        if(Token::isValidOperate($order->id)){
            throw new TokenException([
                "msg" => "订单与用户不匹配",
                "errorCode" =>10003
            ]);
        }
        if($order->status !=1){
            throw new PayException([
                'msg' => '订单已支付过啦',
                'errorCode' => 80003,
                'code' => 400
            ]);
        }
        $this->orderNo =$order->order_no;
        return true;
    }
    private function makeWxPreOrder($totalPrice){
        $openid =Token::getCurrentTokenVar("openid");
        if(!$openid){
            throw new TokenException();
        }
        $wxOrderData =new \WxPayUnifiedOrder();
        $wxOrderData ->SetOut_trade_no($this->orderNo);
        $wxOrderData ->SetBody("零食商返");
        $wxOrderData ->SetTrade_type("JSAPI");
        $wxOrderData ->SetOpenid($openid);
        $wxOrderData ->SetTotal_fee($totalPrice*100);
        $wxOrderData->SetNotify_url("www.baidu.com");

        return $this->getPaySignature($wxOrderData);

    }
    private  function getPaySignature($wxOrderData){
        $config = new \WxPayConfig();
        $wxOrder =\WxPayApi::unifiedOrder($config,$wxOrderData);
        var_dump($wxOrder);
        if($wxOrder['return_code'] != 'SUCCESS' || $wxOrder['result_code'] !='SUCCESS'){
            Log::record($wxOrder,'error');
            Log::record('获取预支付订单失败','error');
        }
        $this->recordPreOrder($wxOrder);
        return $wxOrder;

    }
    private function recordPreOrder($wxOrder){
        Order::updatePrepayID($wxOrder,$this->orderID);
    }


}