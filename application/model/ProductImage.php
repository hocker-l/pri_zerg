<?php
/**
 * Created by PhpStorm.
 * User: lsp
 * Date: 2018/12/30
 * Time: 18:28
 */

namespace app\model;


class ProductImage extends BaseModel
{
    protected $hidden =["id","img_id","delete_time","order","product_id"];
    public function relatedProductImg(){
        return self::belongsTo("Image","img_id","id");
    }

}