<?php
/**
 * Created by PhpStorm.
 * User: lsp
 * Date: 2019-01-23
 * Time: 16:47
 */

namespace app\validate;


use app\lib\exception\ParameterException;
use think\Validate;

class OrderPlace extends BaseValidate
{
    protected  $rule =[
        "products" => "checkProducts"
    ];
    protected $singleRule =[
        "product_id" =>"require|isPositiveInteger",
        "count" =>"require|isPositiveInteger"
    ];
    protected function checkProducts($values){
        if(empty($values)){
            throw new ParameterException([
                "msg" =>"商品列表不能为空！"
            ]);
        }
        foreach ($values as $value){
            $this->checkProduct($value);
        }
        return true;
    }
    protected function checkProduct($value){
        $validate =new Validate($this->singleRule);
        $result =$validate->check($value);
        if(!$result){
            throw new ParameterException([
                "msg" =>"商品列表参数错误!"
            ]);
        }

    }

}