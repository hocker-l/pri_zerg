<?php
/**
 * Created by PhpStorm.
 * User: lsp
 * Date: 2019/1/17
 * Time: 15:45
 */

namespace app\lib\exception;


class SuccessMessage extends BaseException
{
    public $code = 201;
    public $msg = 'ok';
    public $errorCode = 0;

}