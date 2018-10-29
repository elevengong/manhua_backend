<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
//---------------------后台------------------------
Route::group(['middleware' => ['web']],function () {
    Route::any('/backend/login','backend\LoginController@login');
    Route::get('/backend/code','backend\LoginController@code');
});

Route::group(['middleware' => ['web','admin.login']],function () {
    Route::get('/backend/index','backend\IndexController@index');
    Route::post('/backend/logout','backend\IndexController@logout');
    Route::post('/backend/changepwd','backend\IndexController@changepwd');

    Route::any('/backend/adminlist','backend\AdminController@adminList');
    Route::any('/backend/admin/changestatus','backend\AdminController@changestatus');
    Route::delete('/backend/admin/delete/{admin_id}','backend\AdminController@delete')->where(['admin_id' => '[0-9]+']);
    Route::post('/backend/admin/add','backend\AdminController@adminadd');

    //分类
    Route::any('/backend/category/list','backend\CategoryController@categorylist');
    Route::post('/backend/category/changestatus','backend\CategoryController@changestatus');
    Route::any('/backend/category/addcategory','backend\CategoryController@addcategory');
    Route::any('/backend/category/editcategory/{cid}','backend\CategoryController@editcategory')->where(['cid' => '[0-9]+']);
    Route::delete('/backend/category/delete/{cid}','backend\CategoryController@delete')->where(['cid' => '[0-9]+']);

    //会员列表
    Route::any('/backend/user/list','backend\UserController@userlist');
    Route::post('/backend/user/changestatus','backend\UserController@changestatus');
    Route::post('/backend/user/changepwd','backend\UserController@chnagepwd');

    //代理列表
    Route::any('/backend/daili/list','backend\DailiController@daililist');
    Route::post('/backend/daili/changestatus','backend\DailiController@changestatus');
    Route::post('/backend/daili/changepwd','backend\DailiController@chnagepwd');
    Route::any('/backend/daili/adddaili','backend\DailiController@adddaili');

    //漫画管理
    Route::any('/backend/manhua/manhualist','backend\ManhuaController@manhualist');
    Route::any('/backend/manhua/addmanhua','backend\ManhuaController@addmanhua');
    Route::any('/backend/manhua/editmanhua','backend\ManhuaController@editmanhua');

    Route::any('/backend/manhua/chapterlist','backend\ManhuaController@chapterlist');
    Route::any('/backend/manhua/addchapter','backend\ManhuaController@addchapter');
    Route::any('/backend/manhua/editchapter','backend\ManhuaController@editchapter');

    Route::any('/backend/manhua/deal','backend\ManhuaController@deal');





    //广告会员充值
    Route::any('/backend/money/applydeposit','backend\DepositController@applydeposit');
    Route::get('/backend/money/dealdepositorder/{deposit_id}','backend\DepositController@dealdepositorder')->where(['deposit_id' => '[0-9]+']);
    Route::any('/backend/money/updatedepositorder/{deposit_id}','backend\DepositController@updatedepositorder')->where(['deposit_id' => '[0-9]+']);

    Route::any('/backend/money/deposit','backend\DepositController@depositrecord');





    //图片上传
    Route::any('/backend/upload','backend\JobController@upload');
    Route::any('/backend/uploadphoto/{id}','MyController@uploadphoto');
});






