<?php
/**
 * Created by PhpStorm.
 * User: lsp
 * Date: 2018/12/25
 * Time: 16:29
 */

namespace app\validate;


use think\Request;
use think\Response;
use think\Validate;

class BaseValidate extends Validate
{
    public function goCheck(){
        $request =Request::instance();
        $params =$request->param();
        if(!$this->check($params)){

        }
    }

}