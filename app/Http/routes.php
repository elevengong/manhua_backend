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
    Route::any('/backend/manhua/editmanhua/{manhua_id}','backend\ManhuaController@editmanhua')->where(['manhua_id' => '[0-9]+']);
    Route::any('/backend/manhua/chapterlist/{manhua_id}','backend\ManhuaController@chapterlist')->where(['manhua_id' => '[0-9]+']);
    Route::any('/backend/manhua/addchapter','backend\ManhuaController@addchapter');
    Route::any('/backend/manhua/editchapter/{chapter_id}','backend\ManhuaController@editchapter')->where(['chapter_id' => '[0-9]+']);
    Route::get('/backend/manhua/viewchapterphotos/{chapter_id}','backend\ManhuaController@viewchapterphotos')->where(['chapter_id' => '[0-9]+']);
    Route::any('/backend/manhua/savechapterphotos/{chapter_id}','backend\ManhuaController@savechapterphotos')->where(['chapter_id' => '[0-9]+']);

    //扫描入库
    Route::any('/backend/manhua/deal','backend\ManhuaController@deal');

    //会员充值
    Route::any('/backend/money/applydepositlist','backend\DepositController@depositlist');
    Route::get('/backend/money/viewdeposit/{deposit_id}','backend\DepositController@applydepositlist')->where(['deposit_id' => '[0-9]+']);
    //人工审核
    Route::any('/backend/money/verifydepositbyadmin/{deposit_id}','backend\DepositController@verifydepositbyadmin')->where(['deposit_id' => '[0-9]+']);

    //代理提现
    Route::any('/backend/money/applywithdrawlist','backend\WithdrawController@applywithdrawlist');




    //图片上传
    Route::any('/backend/uploadphoto/{id}','MyController@uploadphoto');
});






