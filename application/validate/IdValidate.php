<?php
/**
 * Created by PhpStorm.
 * User: lsp
 * Date: 2018/12/25
 * Time: 16:29
 */

namespace app\validate;


use think\Validate;

class IdValidate extends BaseValidate
{
    protected $rule=[
        "id"=>"require|isPositiveInteger"
    ];


}