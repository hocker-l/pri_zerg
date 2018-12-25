<?php
/**
 * Created by PhpStorm.
 * User: lsp
 * Date: 2018/12/25
 * Time: 15:28
 */

namespace app\model;


class Image extends BaseModel
{
    protected $hidden=["id","delete_time","update_time","from"];
    public function  getUrlAttr($value,$data)
    {
        return self::prefixImgUrl($value,$data);
    }
}