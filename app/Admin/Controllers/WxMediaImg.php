<?php

namespace App\Admin\Controllers;

use App\Model\WxMediaImgModel;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use GuzzleHttp\Client;
use App\Model\WxUserModel;

class WxMediaImg extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '图片素材管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new WxMediaImgModel);

        $grid->column('id', __('Id'));
        $grid->column('media_id', __('Media id'));
        $grid->column('local_path', __('Local path'))->image();
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(WxMediaImgModel::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('media_id', __('Media id'));
        $show->field('local_path', __('Local path'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new WxMediaImgModel);

        $form->image('local_path', __('图片'))->uniqueName();

        //表单提交保存后回调函数
        $form->saved(function (Form $form) {
            $d = $form->model();
            //dd($d->id);     //获取自增ID
            //新增临时素材
            $media_info = $this->mediaUpload(storage_path('app/public/'.$d->local_path),'image');
            $m = json_decode($media_info,true);
            $d->where(['id'=>$d->id])->update(['media_id'=>$m['media_id']]);
        });

        return $form;
    }


    /**
     * 新增临时素材
     */
    protected function mediaUpload($local_file_path,$media_type)
    {
        $access_token = WxUserModel::getAccessToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/media/upload?access_token='.$access_token.'&type='.$media_type;
        $client = new Client();
        $response = $client->request('POST',$url,[
            'multipart' => [
                [
                    'name'      => 'media',
                    'contents'  => fopen($local_file_path,'r')
                ]
            ]
        ]);

        return $response->getBody();
    }
}
