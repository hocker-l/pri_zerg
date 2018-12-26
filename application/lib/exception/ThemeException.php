<?php
/**
 * Created by PhpStorm.
 * User: lsp
 * Date: 2018/12/26
 * Time: 16:25
 */

namespace app\lib\exception;


class ThemeException extends BaseException
{
    public $code=400;
    public $msg="指定ID主题不存在！";
    public $errorCode=10000;

}