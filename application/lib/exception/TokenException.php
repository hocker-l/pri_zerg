<?php
/**
 * Created by PhpStorm.
 * User: lsp
 * Date: 2019/1/17
 * Time: 10:55
 */

namespace app\lib\exception;


class TokenException extends BaseException
{
    public $code =401;
    public $msg = "Token已过期或Token无效！";
    public $errorCode =10001;

}