<?php
/**
 * Created by PhpStorm.
 * User: lsp
 * Date: 2018/12/25
 * Time: 17:05
 */

namespace app\lib\exception;


class ParameterException extends BaseException
{
    public $code=400;
    public $msg="参数错误";
    public $errorCode=10000;

}