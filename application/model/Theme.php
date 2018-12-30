<?php
/**
 * Created by PhpStorm.
 * User: lsp
 * Date: 2018/12/26
 * Time: 15:48
 */

namespace app\model;


use app\validate\IdsValidate;

class Theme extends BaseModel
{
    protected $hidden=["topic_img_id","delete_time","head_img_id","update_time"];

      public function relatedTopicImg(){
          return $this->belongsTo("Image","topic_img_id","id");
      }
    public function relatedHeadImg(){
        return $this->belongsTo("Image","head_img_id","id");
    }
      public  static function getThemeByIds($id_arr){
          $theme = self::with(["relatedTopicImg","relatedHeadImg"])->select($id_arr);
          return $theme;
      }

}