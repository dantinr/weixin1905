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

}
