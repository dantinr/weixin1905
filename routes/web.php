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
Route::get('/test/hello',function(){
    $current_url = $_SERVER['APP_URL'] . $_SERVER['REQUEST_URI'];
    echo 'CURRENT_URL: '.$current_url;echo '</br>';
    echo '<pre>';print_r($_SERVER);echo '</pre>';
});
Route::get('/test/adduser','User\LoginController@addUser');
Route::get('/test/redis1','Test\TestController@redis1');
Route::get('/test/redis2','Test\TestController@redis2');
Route::get('/test/xml','Test\TestController@xmlTest');
Route::get('/dev/redis/del','VoteController@delKey');

Route::get('/test/baidu','Test\TestController@baidu');
Route::get('/test/redis/hash','Test\TestController@redisHash');

//微信开发

Route::get('/wx/test','WeiXin\WxController@test');
Route::get('/wx/login','WeiXin\WxController@login');		// 微信网页登录
Route::get('/wx','WeiXin\WxController@wechat');
Route::post('/wx','WeiXin\WxController@receiv');        //接收微信的推送事件
Route::get('/wx/media','WeiXin\WxController@getMedia');        //获取临时素材
Route::get('/wx/flush/access_token','WeiXin\WxController@flushAccessToken');        //刷新access_token
Route::get('/wx/menu','WeiXin\WxController@createMenu');        //创建菜单
Route::get('/wx/qrcode','WeiXin\WxQRController@qrcode');        //创建才参数的我二维码
Route::get('/wx/newyear','WeiXin\WxController@newYear');        //元旦活动页面


//微信公众号
Route::get('/vote','VoteController@index');        //微信投票


//微商城
Route::get('/goods/detail','Goods\IndexController@detail');        //商品详情


//计划任务
Route::get('/crontab/send_msg','Crontab\WeiXinController@sendMsg');        // 定时群发


