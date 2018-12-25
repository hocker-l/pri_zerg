<?php
/**
 * Created by PhpStorm.
 * User: lsp
 * Date: 2018/12/25
 * Time: 14:35
 */

namespace app\model;


class Banner extends BaseModel
{
    protected $hidden=["delete_time","update_time","id"];
    //关联banner_item表
    public function relatedItems(){
        return self::hasMany("banner_item","banner_id","id");
    }
    //根据banner的id取得所要的数据
    public static function getBannerById($id){
        $banner=self::with(["relatedItems","relatedItems.relatedImage"])->select($id);
        return $banner;
    }
}