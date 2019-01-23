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

    public static function getAddressByUid($uid){
        $userAddress =self::where("user_id","=",$uid);
        return $userAddress;
    }


}