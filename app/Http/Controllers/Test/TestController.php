<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

use GuzzleHttp\Client;

class TestController extends Controller
{
	public function hello()
	{
		echo "Hello World  1905 aaaa bbbbb ccccc";
	}



    public function redis1()
    {
        $key = 'weixin';
        $val = 'hello world';
        Redis::set($key,$val);

        echo time();echo '</br>';
        echo date('Y-m-d H:i:s');

    }

    public function redis2()
    {

        $key = 'weixin';
        echo Redis::get($key);
    }


    /**
     * 请求百度
     */
    public function baidu()
    {

        $url = 'https://theory.gmw.cn/2019-12/05/content_33377331.htm';
        $client = new Client();
        $response = $client->request('GET',$url);
        echo $response->getBody();

    }

    public function xmlTest()
    {

        $xml_str = '<xml>
<ToUserName><![CDATA[gh_de1c8ade602d]]></ToUserName>
<FromUserName><![CDATA[oLreB1jAnJFzV_8AGWUZlfuaoQto]]></FromUserName>
<CreateTime>1575858800</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[aaa]]></Content>
<MsgId>22560871709117840</MsgId>
</xml>';

        $xml_obj = simplexml_load_string($xml_str);
        echo '<pre>';print_r($xml_obj);echo '</pre>';die;
        echo '<pre>';print_r($xml_obj);echo '</pre>';echo '<hr>';

        echo 'ToUserName: '. $xml_obj->ToUserName;echo '</br>';
        echo 'FromUserName: '.$xml_obj->FromUserName;echo '</br>';

    }

    public function redisHash(){
        $u = [
            'openid'    => 'sldkfjsldf',
            'nickname'  => 'zhangsan',
            'email'     => 'zhangsan@qq.com',
            'age'       => 33,
            'sex'       => 1,
        ];

//        $k = '1905_h:u:123';
//
//        $redis = new \Redis();
//        $redis->connect('127.0.0.1');
//        $u = $redis->hMGet($k,['nickname','email']);
//        echo '<pre>';print_r($u);echo '</pre>';
//        echo '<hr>';

        $k = 'h:u:123';
        //Redis::hMset($k,$u);
        $user_info = Redis::hMget($k,true,["nickname","email"]);
        var_dump($user_info);echo '<hr>';
        //$user_info = Redis::hMget($k,['openid','nickname','email']);
        //$user_info = Redis::hMget($k,array('openid','nickname','email'));
        echo '<pre>';print_r($user_info);echo '</pre>';

    }

}
