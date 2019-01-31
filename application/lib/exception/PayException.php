<?php
/**
 * Created by PhpStorm.
 * User: lsp
 * Date: 2019-01-28
 * Time: 15:43
 */

namespace app\lib\exception;


class PayException extends BaseException
{
    public $code = 404;
    public $msg = '支付失败！';
    public $errorCode = 80000;

}