<?php
/**
 * Created by PhpStorm.
 * User: lsp
 * Date: 2019/1/16
 * Time: 14:37
 */

namespace app\service;


use app\lib\enum\ScopeEnum;
use app\lib\exception\TokenException;
use app\lib\exception\WxChatException;
use app\model\User;
use think\Exception;

class UserToken extends Token
{
    protected $code;
    protected $wxLoginUrl;
    protected $wxAppId;
    protected $wxAppSecret;
    function __construct($code)
    {
        $this->code =$code;
        $this->wxAppId =config("wx.app_id");
        $this->wxAppSecret =config("wx.app_secret");
        $this->wxLoginUrl =sprintf(config("wx.login_url"),$this->wxAppId,$this->wxAppSecret,$this->code);
    }
    public function get(){
        $result =curl_get($this->wxLoginUrl);
        $wxResult =json_decode($result,true);
        if(empty($wxResult)){
            throw  new Exception('获取session_key及openID时异常，微信内部错误');
        }else{
            $loginFail =array_key_exists("errcode",$wxResult);
            if($loginFail){
                $this->processLoginError($wxResult);
            }else{
                return $this->grantToken($wxResult);
            }
        }
    }
    public function processLoginError($wxResult){
        throw  new WxChatException([
            "msg" =>$wxResult["errmsg"],
            "errorCode" =>$wxResult["errcode"]
        ]);
    }
    public function grantToken($wxResult){
        $openid =$wxResult["openid"];
        $user =User::getByOpenID($openid);
        if(!$user){
            $user = User::createUser($openid);
        }
        $uId=$user->id;
        $cachedValue =$this->prepareCachedValue($wxResult,$uId);
        $token= $this->saveToCache($cachedValue);
        return $token;

    }
    public function prepareCachedValue($wxResult, $uid){
        $cachedValue = $wxResult;
        $cachedValue["uid"] =$uid;
        $cachedValue["scope"] = ScopeEnum::User;
        return $cachedValue;
    }
    public function saveToCache($cachedValue){
        $token =self::generateToken();
        $value =json_encode($cachedValue);
        $expire_in =config("setting.token_expire_in");
        $result =cache($token,$value,$expire_in);
        if(!$result){
            throw  new TokenException([
                "msg" => "服务器缓存异常！",
                "errorCode" =>10005
            ]);
        }
        return $token;
    }


}