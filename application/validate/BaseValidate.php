<?php
/**
 * Created by PhpStorm.
 * User: lsp
 * Date: 2018/12/25
 * Time: 16:29
 */

namespace app\validate;


use app\lib\exception\ParameterException;
use think\Request;
use think\Validate;

class BaseValidate extends Validate
{
    public function goCheck(){
        $request =Request::instance();
        $params =$request->param();
        if(!$this->check($params)){
           $ParameterException = new ParameterException([
                "msg"=>is_array($this->error)?implode(";",$this->error):$this->error
            ]);
            throw $ParameterException;
        }
        return true;
    }
    public function isPositiveInteger($value){
        if(is_numeric($value)&&is_int($value+0)){
            return true;
        }else{
            return false;
        }
    }

}