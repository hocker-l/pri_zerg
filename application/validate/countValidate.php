<?php
/**
 * Created by PhpStorm.
 * User: lsp
 * Date: 2018/12/26
 * Time: 16:57
 */

namespace app\validate;


use think\Validate;

class countValidate extends BaseValidate
{
    protected $rule= [
        "count" =>"isPositiveInteger|between:1,15"
    ];

}