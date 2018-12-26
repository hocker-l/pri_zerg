<?php
/**
 * Created by PhpStorm.
 * User: lsp
 * Date: 2018/12/21
 * Time: 17:18
 */

namespace app\api\controller\v1;

use app\lib\exception\BannerMissException;
use \app\model\Banner as BannerModel;
use app\validate\IdValidate;
use think\Exception;
use think\Request;


class Banner
{
    function banner($id){
        (new IdValidate())->goCheck();
        $banner=BannerModel::getBannerById($id);
        if(!$banner){
            throw new  BannerMissException();
        }else{
            return json($banner);
        }
    }
}