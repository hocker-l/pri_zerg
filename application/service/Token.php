<?php
/**
 * Created by PhpStorm.
 * User: lsp
 * Date: 2019/1/16
 * Time: 14:35
 */

namespace app\service;


use app\lib\enum\ScopeEnum;
use app\lib\exception\ForbiddenException;
use app\lib\exception\ParameterException;
use app\lib\exception\TokenException;
use think\Cache;
use think\Exception;
use think\Request;

class Token
{
    public static function generateToken(){
        $randChar =getRandChar(32);
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        $tokenSalt =config("secure.token_salt");
        $str =md5($randChar.$timestamp.$tokenSalt);
        return $str;
    }
    public static function  getCurrentTokenVar($key){
        $token = Request::instance()
            ->header('token');
        $tokenCache =Cache::get($token);
        if(!$tokenCache){
            throw  new TokenException();
        }else{
            if(!is_array($tokenCache)){
                $tokenCache =json_decode($tokenCache,true);
            }
            if(array_key_exists($key,$tokenCache)){
                return $tokenCache[$key];
            }else{
                throw new Exception('尝试获取的Token变量并不存在');
            }

        }
    }
    public static function getCurrentUid(){
        $uid= self::getCurrentTokenVar("uid");
        $scope =self::getCurrentTokenVar("scope");
        if($scope ==ScopeEnum::Super){
            $userID = input("get.uid");
            if(!$userID){
                throw new ParameterException([
                    "msg" =>"没有指定需要操作的用户对象"
                ]);
            }
            return $userID;
        }else{
            return $uid;
        }
    }
    //验证token是否合法或者是否过期
    //验证器验证只是token验证的一种方式
    //另外一种方式是使用行为拦截token，根本不让非法token
    //进入控制器
    public static function needPrimaryScope(){
        $scope =self::getCurrentTokenVar("scope");
        if($scope){
            if($scope>=ScopeEnum::User){
                return true;
            }else{
                throw new ForbiddenException();
            }
        }else{
            throw new TokenException();
        }
    }
    // 用户专有权限
    public static function needExclusiveScope(){
        $scope =self::getCurrentTokenVar("scope");
        if($scope){
            if($scope==ScopeEnum::User){
                return true;
            }else{
                throw new ForbiddenException();
            }
        }else{
            throw new TokenException();
        }
    }
    public static function needSuperScope(){
        $scope =self::getCurrentTokenVar("scope");
        if($scope){
            if($scope==ScopeEnum::Super){
                return true;
            }else{
                throw new ForbiddenException();
            }
        }else{
            throw new TokenException();
        }
    }
    public static function verifyToken($token){
        $exist = Cache::get($token);
        if($exist){
            return true;
        }else{
            return false;
        }
    }
}