<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

class WxUserModel extends Model
{
    protected $table = 'p_wx_users';
    protected $primaryKey = 'uid';


    public static function getAccessToken()
    {

        $key = 'wx_access_token';

        $access_token = Redis::get($key);
        if($access_token){
            return $access_token;
        }

        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.env('WX_APPID').'&secret='.env('WX_APPSECRET');
        $data_json = file_get_contents($url);
        $arr = json_decode($data_json,true);

        Redis::set($key,$arr['access_token']);
        Redis::expire($key,3600);
        return $arr['access_token'];
    }



}
