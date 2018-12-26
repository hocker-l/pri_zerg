<?php
/**
 * Created by PhpStorm.
 * User: lsp
 * Date: 2018/12/26
 * Time: 15:53
 */

namespace app\validate;


class IdsValidate extends BaseValidate
{
    protected $rule=[
        "ids" =>"require|checkIds"
    ];
    protected $message=[
        "ids"=>"ids必须为逗号隔开的正整数！"
    ];
    public function checkIds($value){
        $id_arr=explode(",",$value);
        if(empty($id_arr)){
            return false;
        }else{
            foreach ($id_arr as $key=>$id){
                if(!$this->isPositiveInteger($id)){
                    return false;
                }
            }
            return true;
        }

    }
}