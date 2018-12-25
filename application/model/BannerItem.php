<?php
/**
 * Created by PhpStorm.
 * User: lsp
 * Date: 2018/12/25
 * Time: 14:55
 */

namespace app\model;


class BannerItem extends BaseModel
{
     protected $hidden=["delete_time","update_time","banner_id","id","img_id"];
//     关联image表拿到图片地址
     public function relatedImage(){
        return self::belongsTo("Image","img_id","id");
     }

}