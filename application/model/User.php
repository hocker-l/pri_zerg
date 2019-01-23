<?php
/**
 * Created by PhpStorm.
 * User: lsp
 * Date: 2019/1/16
 * Time: 16:48
 */

namespace app\model;


class User extends BaseModel
{
    public function relatedUserAddress(){
        return $this->hasOne("UserAddress","user_id","id");
    }
    public static function getByOpenID($openid){
        $user = User::where("openid","=",$openid)->find();
        return $user;
    }
    public static function createUser($openid){
        $user = User::create([
            "openid" =>$openid
        ]);
        return $user;
    }


}