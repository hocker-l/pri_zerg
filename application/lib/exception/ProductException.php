<?php
/**
 * Created by PhpStorm.
 * User: lsp
 * Date: 2018/12/30
 * Time: 13:05
 */

namespace app\lib\exception;


class ProductException extends BaseException
{
    public $code =404;
    public $msg = "指写的商品不存在，请检查参数";
    public $errorCode =20000;

}