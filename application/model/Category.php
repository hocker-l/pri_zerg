<?php
/**
 * Created by PhpStorm.
 * User: lsp
 * Date: 2018/12/30
 * Time: 11:30
 */

namespace app\model;


class Category extends BaseModel
{
    protected $hidden=["topic_img_id","delete_time","update_time"];
    //关联topicImg
    public function relatedTopicImg(){
        return $this->belongsTo("Image","topic_img_id","id");
    }
    public static function allCategory(){
       $allCategoty = self::all([],"relatedTopicImg");
       return $allCategoty;
    }


}