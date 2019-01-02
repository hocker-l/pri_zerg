<?php
/**
 * Created by PhpStorm.
 * User: lsp
 * Date: 2018/12/30
 * Time: 11:41
 */

namespace app\api\controller\v1;

use app\lib\exception\CategoryException;
use \app\model\Category as categotyModel;

class Category
{
    function getAllCategoty(){
      $allCategory =  categotyModel::allCategory();
      if(!$allCategory){
           throw new CategoryException();
      }
      return json($allCategory);
    }

}