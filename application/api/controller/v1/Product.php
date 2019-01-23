<?php
/**
 * Created by PhpStorm.
 * User: lsp
 * Date: 2018/12/26
 * Time: 16:42
 */

namespace app\api\controller\v1;

use app\lib\exception\ProductException;
use \app\model\Product as productModel;
use app\validate\countValidate;
use app\validate\IdValidate;

class Product
{
    public function getRecent($count=15){
        (new countValidate())->goCheck();
        $product = productModel::getRecentProducts($count);
        return json($product);
    }
    public function ProductByCatetoryId($id){
        (new IdValidate())->goCheck();
        $products = productModel::getProductsByCategory($id);
        if (!$products){
            throw new ProductException();
        }
        return json($products);
    }
    public function productById($id){
        (new IdValidate())->goCheck();
        $products =productModel::getProductById($id);
        if (!$products){
            throw new ProductException();
        }
        return json($products);

    }


}