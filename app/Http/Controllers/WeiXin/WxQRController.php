<?php

namespace App\Http\Controllers\WeiXin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\WxUserModel;
use GuzzleHttp\Client;

class WxQRController extends Controller
{


    public function qrcode()
    {
        $scene_id = $_GET['scene'];        //二维码参数

        $access_token = WxUserModel::getAccessToken();
        // 第一步 获取ticket
        $url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$access_token;

        // {"expire_seconds": 604800, "action_name": "QR_SCENE", "action_info": {"scene": {"scene_id": 123}}}
        $data1 = [
            'expire_seconds'    => 604800,
            'action_name'       => 'QR_SCENE',
            'action_info'       => [
                'scene' => [
                    'scene_id'  => $scene_id
                ]
            ]
        ];

        $client = new Client();
        $response = $client->request('POST',$url,[
            'body'  => json_encode($data1)
        ]);

        $json1 = $response->getBody();
        $tiket = json_decode($json1,true)['ticket'];

        // 第二步 获取带参数的二维码
        $url = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.$tiket;

        return redirect($url);

    }


}
