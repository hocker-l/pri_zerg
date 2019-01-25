<?php
/**
 * Created by PhpStorm.
 * User: lsp
 * Date: 2019-01-23
 * Time: 16:10
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\validate\OrderPlace;
use app\service\Token;
use app\service\Order as orderService;

class Order extends BaseController
{
    protected  $beforeActionList =[
        "checkExclusiveScope" => ["only" =>"placeOrder"]
    ];
    public function placeOrder(){
        (new OrderPlace())->goCheck();
        $products =input("post.products/a");
        $uid = Token::getCurrentUid();
        $order = new orderService();
        $statues = $order->place($uid,$products);
        return $statues;
    }

}