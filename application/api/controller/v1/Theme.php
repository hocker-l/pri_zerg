<?php
/**
 * Created by PhpStorm.
 * User: lsp
 * Date: 2018/12/26
 * Time: 16:14
 */

namespace app\api\controller\v1;


use app\lib\exception\ThemeException;
use \app\model\Theme as themeModel;
use app\validate\IdsValidate;

class Theme
{
    public  function getTheme($ids){
        (new IdsValidate())->goCheck();
        $id_arr=explode(",",$ids);
        $theme =themeModel::getThemeByIds($id_arr);
        if(!$theme){
            throw new ThemeException();
        }
       return json($theme);
    }

}