<?php
/**
 * Created by PhpStorm.
 * User: lsp
 * Date: 2018/12/26
 * Time: 16:42
 */

namespace app\api\controller\v1;

use \app\model\Product as productModel;
use app\validate\countValidate;

class Product
{
    public function getRecent($count=15){
        (new countValidate())->goCheck();
        $product = productModel::getRecentProducts($count);
        return json($product);
    }

}