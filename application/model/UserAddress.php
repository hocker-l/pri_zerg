<?php
/**
 * Created by PhpStorm.
 * User: lsp
 * Date: 2019/1/17
 * Time: 14:31
 */

namespace app\model;


class UserAddress extends BaseModel
{
    protected $hidden =["id","user_id","delete_time"];
    public static function getAddressByUid($uid){
        $userAddress =self::where("user_id","=",$uid)->find();
        return $userAddress;
    }


}