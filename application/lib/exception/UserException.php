<?php
/**
 * Created by PhpStorm.
 * User: lsp
 * Date: 2019/1/17
 * Time: 15:37
 */

namespace app\lib\exception;


class UserException extends BaseException
{
    public $code = 404;
    public $msg = '用户不存在';
    public $errorCode = 60000;
}