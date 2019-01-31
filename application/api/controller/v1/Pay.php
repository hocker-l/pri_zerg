<?php
/**
 * Created by PhpStorm.
 * User: lsp
 * Date: 2019-01-28
 * Time: 15:21
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\validate\IdValidate;
use app\service\Pay as payService;

class Pay extends BaseController
{
    protected $beforeActionList =[
        "checkExclusiveScope" =>["only" =>"getPreOrder"]
    ];
    public function getPreOrder($id=""){
        (new IdValidate()) ->goCheck();
        $pay = new payService($id);
        $pay->pay();


    }

}