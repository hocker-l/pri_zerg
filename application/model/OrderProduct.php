<?php
/**
 * Created by PhpStorm.
 * User: lsp
 * Date: 2019-01-25
 * Time: 14:47
 */

namespace app\model;


class OrderProduct extends BaseModel
{
    protected $hidden =["order_id","delete_time","update_time"];
    public static function insertOrderProduct($orderArr){
        $order =new OrderProduct();
        $reslut =$order->saveAll($orderArr);
        return $reslut;
    }
    public static function getoProductById($orderId){
        $oProducts =self::where("order_id","=",$orderId)->select();
        return $oProducts;
    }
}