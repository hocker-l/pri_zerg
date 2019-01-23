<?php
/**
 * Created by PhpStorm.
 * User: lsp
 * Date: 2019/1/16
 * Time: 9:26
 */

namespace app\validate;


class TokenGet extends  BaseValidate
{
    protected  $rule=["code"=>"require|isNotEmpty"];

    protected $message=["code"=>"没有code是不能获取token的喔！"];
}