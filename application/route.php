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


Route::rule("api/:version/recent/:count","api/:version.Product/getRecent");

Route::rule("api/:version/category/all","api/:version.Category/getAllCategoty");

Route::rule("api/:version/product/by_category/:id","api/:version.Product/ProductByCatetoryId");

Route::rule("api/:version/product/:id","api/:version.Product/productById");

Route::rule("api/:version/theme/product/:id","api/:version.Theme/getProductByTheme");

Route::rule("api/:version/theme/:ids","api/:version.Theme/getTheme");