<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});


Route::get('/','Index\IndexController@index');      //网站首页

Route::get('/info',function(){
	phpinfo();
});
Route::get('/test/hello','Test\TestController@hello');
Route::get('/test/adduser','User\LoginController@addUser');
Route::get('/test/redis1','Test\TestController@redis1');
Route::get('/test/redis2','Test\TestController@redis2');
Route::get('/test/xml','Test\TestController@xmlTest');
Route::get('/dev/redis/del','VoteController@delKey');

Route::get('/test/baidu','Test\TestController@baidu');
Route::get('/test/redis/hash','Test\TestController@redisHash');

//微信开发

Route::get('/wx/test','WeiXin\WxController@test');
Route::get('/wx','WeiXin\WxController@wechat');
Route::post('/wx','WeiXin\WxController@receiv');        //接收微信的推送事件
Route::get('/wx/media','WeiXin\WxController@getMedia');        //获取临时素材
Route::get('/wx/flush/access_token','WeiXin\WxController@flushAccessToken');        //刷新access_token
Route::get('/wx/menu','WeiXin\WxController@createMenu');        //创建菜单


//微信公众号
Route::get('/vote','VoteController@index');        //微信投票


//微商城
Route::get('/goods/detail','Goods\IndexController@detail');        //商品详情


