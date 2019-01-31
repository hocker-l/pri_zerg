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
    protected function isPositiveInteger($value, $rule='', $data='', $field='')
    {
        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
            return true;
        }
        return $field . '必须是正整数';
    }
    public function isNotEmpty($value,$rule="",$data="",$field=""){
        if(empty($value)){
            return $field."不能为空！";
        }else{
            return true;
        }
    }
    public function isMobile($value){
        $rule1 = '^1(3|4|5|7|8)[0-9]\d{8}$^'; //手机验证
        $result1 = preg_match($rule1, $value);
        $rule2 ="/^0\d{2,3}-?\d{7,8}$/";      //电话验证
        $result2 = preg_match($rule2, $value);
        if ($result1 || $result2) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * @param array $arrays 通常传入request.post变量数组
     * @return array 按照规则key过滤后的变量数组
     * @throws ParameterException
     */
    public function getDataByRule($arrays)
    {
        if(array_key_exists("user_id",$arrays)||array_key_exists("uid",$arrays)){
            throw new ParameterException([
                'msg' => '参数中包含有非法的参数名user_id或者uid'
            ]);
        }
        $newArray =[];
        foreach ($this->rule as $key =>$value){
            $newArray[$key] =$arrays [$key];
        }
        return $newArray;
    }
}