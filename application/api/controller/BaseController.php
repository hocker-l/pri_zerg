<?php
/**
 * Created by PhpStorm.
 * User: lsp
 * Date: 2019/1/17
 * Time: 14:39
 */

namespace app\api\controller;


use app\service\Token;
use think\Controller;

class BaseController extends Controller
{
    protected function checkExclusiveScope()
    {
        Token::needExclusiveScope();
    }

    protected function checkPrimaryScope()
    {
        Token::needPrimaryScope();
    }

    protected function checkSuperScope()
    {
        Token::needSuperScope();
    }

}