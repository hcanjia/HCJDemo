<?php
/**
 * Created by PhpStorm.
 * User: HCJ
 * Date: 2017/8/20
 * Time: 12:02
 */

namespace app\admin\controller;

use app\admin\model\Category as CategoryModel;
use app\lib\exception\ReturnSuccess;
use think\Request;

class Menu extends BaseController
{
    public function menu()
    {
        return $this->fetch();
    }

    public function add()
    {
        return $this->fetch();
    }

    public function getSelectList()
    {
        $list=CategoryModel::all();
        return $list->hidden(['summary']);
    }

    public function upload()
    {
        //接收文件
        $request = Request::instance();
        $img=$request->file('file');
        //1048576字节    验证图片，并移动到相应位置
        $info = $img->validate(['size'=>1048576,'ext' => 'jpg,png,jpeg'])->move(ROOT_PATH . 'public' . DS
            . 'uploads',date('Ymd').DS.'me'.time());
        if ($info) {
            $imgName=$info->getSaveName();
            $imgName=str_replace("\\","/",$imgName);
            $url=config('setting.uploads_img_prefix').$imgName;
            return json( new ReturnSuccess([
                'imgName'=>$imgName,
                'url' => $url
            ]));
        } else {
            return json(['code'=>400,'msg'=>'上传失败']);
        }
    }
}