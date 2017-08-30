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

use think\Route;
//Admin
Route::get('admin/index','admin/index/index');

//Table
Route::get('admin/table/add','admin/Table/add');
Route::post('admin/table/add','admin/Table/addAjax');
Route::post('admin/table/list','admin/Table/listAjax');
Route::get('admin/table/del/:id','admin/Table/delAjax', [],['id'=>'\d+']);
Route::get('admin/table/del','admin/Table/delSelectAjax');

//Wx
Route::rule('admin/wx/code','admin/WxCreateCode/createCode');

//Category
Route::get('admin/category/add', 'admin/Category/add');
Route::rule('admin/category/upload', 'admin/Category/upload');
Route::post('admin/category/add', 'admin/Category/addAjax');
Route::post('admin/category/list','admin/Category/listAjax');
Route::get('admin/category/del/:id','admin/Category/delAjax', [],['id'=>'\d+']);
Route::get('admin/category/del','admin/Category/delSelectAjax');


Route::get('admin/menu/add', 'admin/Menu/add');
Route::rule('admin/menu/upload', 'admin/Menu/upload');
Route::post('admin/menu/add', 'admin/Menu/addAjax');
Route::post('admin/menu/list','admin/Menu/listAjax');
Route::get('admin/menu/del/:id','admin/Menu/delAjax', [],['id'=>'\d+']);
Route::get('admin/menu/del','admin/Menu/delSelectAjax');
Route::get('admin/menu/select','admin/menu/getSelectList');







//Api
Route::get('api/:version/banner/:id', 'api/:version.Banner/getBanner');

Route::get('api/:version/theme', 'api/:version.Theme/getSampleList');
Route::get('api/:version/theme/:id', 'api/:version.Theme/getComplexOne');

Route::get('api/:version/product/recent', 'api/:version.Product/getRecent');
Route::get('api/:version/product/by_category', 'api/:version.Product/getAllInCategory');
Route::get('api/:version/product/:id', 'api/:version.Product/getOne');

Route::get('api/:version/category/all', 'api/:version.Category/getAllCategory');

Route::post('api/:version/token/user', 'api/:version.Token/getToken');

Route::post('api/:version/address/user', 'api/:version.Address/createOrUpdateAddress');

Route::post('api/:version/order', 'api/:version.Order/placeOrder');
Route::get('api/:version/order/by_user', 'api/:version.Order/getSummaryByUser');
Route::get('api/:version/order/:id', 'api/:version.Order/getDetail', [],['id'=>'\d+']);

Route::post('api/:version/pay/pre_order', 'api/:version.Pay/getPreOrder');
Route::post('api/:version/pay/notify', 'api/:version.Pay/receiveNotify');


