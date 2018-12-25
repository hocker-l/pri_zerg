<?php
/**
 * Created by PhpStorm.
 * User: lsp
 * Date: 2018/12/25
 * Time: 14:37
 */

namespace app\model;


use think\Model;

class BaseModel extends Model
{
        public function prefixImgUrl($value,$data){
            $finalUrl=$value;
            if($data['from']==1){
                $finalUrl = config("setting.img_prefix").$value;
            }
            return $finalUrl;
        }

}