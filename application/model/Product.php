<?php
/**
 * Created by PhpStorm.
 * User: lsp
 * Date: 2018/12/26
 * Time: 16:43
 */

namespace app\model;


class Product extends BaseModel
{
    protected $hidden=["delete_time","category_id","main_img_url","from","create_time","update_time","summary","img_id"];
    public function relatedImage(){
        return self::belongsTo("Image","img_id","id");
    }
    public static function getRecentProducts($count){
       $product  = self::with("relatedImage")->order("create_time desc")->limit($count)->select();
        return $product;
    }

}