<?php
/**
 * Created by PhpStorm.
 * User: lsp
 * Date: 2019/1/16
 * Time: 9:20
 */

namespace app\api\controller\v1;


use app\lib\exception\ParameterException;
use app\service\UserToken;
use app\validate\TokenGet;
use \app\service\Token as TokenService;

class Token
{
    public function  getToken($code=""){
        (new TokenGet())->goCheck();
        $wx =new UserToken($code);
        $token =$wx ->get();
        return $token;
    }
    public function verifyToken($token=''){
        if(!$token){
            throw new ParameterException([
                "msg" =>"token不允许为空!"
            ]);
        }
        $valid =TokenService::verifyToken($token);
        return json(['isValid' =>$valid]);
    }
}