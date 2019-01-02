<?php
/**
 * Created by PhpStorm.
 * User: lsp
 * Date: 2018/12/30
 * Time: 12:51
 */

namespace app\lib\exception;


class CategoryException extends BaseException
{
    public $code =404;
    public $msg = "指定类目不存在，请检查参数！";
    public $errorCode =50000;

}