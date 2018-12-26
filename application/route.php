<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use  think\Route;

Route::rule("api/:version/banner/:id","api/:version.Banner/banner");

Route::rule("api/:version/theme/:ids","api/:version.Theme/getTheme");

Route::rule("api/:version/recent/:count","api/:version.Product/getRecent");