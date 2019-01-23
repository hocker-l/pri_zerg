<?php
/**
 * Created by PhpStorm.
 * User: lsp
 * Date: 2019/1/16
 * Time: 16:13
 */

namespace app\lib\exception;


class WxChatException extends BaseException
{
    public $code = 400;
    public $msg = 'wechat unknown error';
    public $errorCode = 999;
}