<?php

namespace App\Http\Controllers\Crontab;

use App\Http\Controllers\Controller;
use App\Model\WxUserModel;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class WeiXinController extends Controller
{

    public function sendMsg()
    {
        echo __METHOD__;echo "\n";

        //请求第三方接口 获取天气
        $weather_api = 'https://free-api.heweather.net/s6/weather/now?location=beijing&key=d957029d5931428f8eef6ba241aefdd7';
        $weather_info = file_get_contents($weather_api);
        $weather_info_arr = json_decode($weather_info,true);
        $cond_txt = $weather_info_arr['HeWeather6'][0]['now']['cond_txt'];
        $tmp = $weather_info_arr['HeWeather6'][0]['now']['tmp'];
        $wind_dir = $weather_info_arr['HeWeather6'][0]['now']['wind_dir'];

        $msg = $cond_txt . ' 温度： '.$tmp . ' 风向： '. $wind_dir;
        echo $msg;echo "\n";


        //获取用户列表
        $openid_arr = WxUserModel::select('openid','nickname','sex')->get()->toArray();
        $openid = array_column($openid_arr,'openid');
        echo '<pre>';print_r($openid);echo '</pre>';

        $access_token = WxUserModel::getAccessToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token='.$access_token;
        $msg = date('Y-m-d H:i:s') . ' ' .$msg;

        //群发
        $data = [
            'touser'    => $openid,
            'msgtype'   => 'text',
            'text'      => ['content'=>$msg]
        ];

        $client = new Client();
        $response = $client->request('POST',$url,[
            'body'  => json_encode($data,JSON_UNESCAPED_UNICODE)
        ]);

        echo $response->getBody();echo "\n";

    }
}
