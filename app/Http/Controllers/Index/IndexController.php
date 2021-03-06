<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Model\WxUserModel;

class IndexController extends Controller
{

    public function index()
    {

        //微信配置
        $nonceStr = Str::random(8);
        $wx_config = [
            'appId'     => env('WX_APPID'),
            'timestamp' => time(),
            'nonceStr'  => $nonceStr,
        ];

        $ticket = WxUserModel::getJsapiTicket();        // 获取 jsapi_ticket
        $url = $_SERVER['APP_URL'] . $_SERVER['REQUEST_URI'];;      //  当前url
        $jsapi_signature = WxUserModel::jsapiSign($ticket,$url,$wx_config); //计算签名
        $wx_config['signature'] = $jsapi_signature;

        $data = [
            //'u'         => $user_info,
            'wx_config' => $wx_config
        ];
        return view('index.index',$data);
    }



    /**
     * 根据code获取access_token
     * @param $code
     */
    protected function getAccessToken($code)
    {
        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.env('WX_APPID').'&secret='.env('WX_APPSECRET').'&code='.$code.'&grant_type=authorization_code';
        $json_data = file_get_contents($url);
        return json_decode($json_data,true);
    }


    /**
     * 获取用户基本信息
     * @param $access_token
     * @param $openid
     */
    protected function getUserInfo($access_token,$openid)
    {
        $url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';
        $json_data = file_get_contents($url);
        $data = json_decode($json_data,true);
        if(isset($data['errcode'])){
            // TODO  错误处理
            die("出错了 40001");       // 40001 标识获取用户信息失败
        }
        return $data;           // 返回用户信息
    }


}
