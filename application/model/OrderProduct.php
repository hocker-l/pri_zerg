<?php
/**
 * Created by PhpStorm.
 * User: lsp
 * Date: 2019-01-25
 * Time: 14:47
 */

namespace app\model;


class OrderProduct extends BaseModel
{
    public static function insertOrderProduct($orderArr){
        $reslut =self::saveAll($orderArr);
        return $reslut;
    }
}