<?php
/**
 * Created by PhpStorm.
 * User: lsp
 * Date: 2019-01-23
 * Time: 16:35
 */

namespace app\model;


class Order extends  BaseModel
{
    public static function saveOrder($orderArr){
        $order =new Order($orderArr);
        $order->save();
        return $order;
    }

}