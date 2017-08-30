<?php
/**
 * Created by PhpStorm.
 * User: HCJ
 * Date: 2017/8/18
 * Time: 12:53
 */

namespace app\admin\controller;


use app\admin\validate\CategoryAddValidate;
use app\admin\validate\IDCollection;
use app\admin\validate\ListValidate;
use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\BaseException;
use app\lib\exception\ReturnSuccess;
use app\lib\exception\SuccessMessage;
use think\Request;
use app\admin\model\Image as ImageModel;
use app\admin\model\Category as CategoryModel;

class Category extends BaseController
{
    public function category()
    {
        return $this->fetch();
    }

    public function add()
    {
        return $this->fetch();
    }

    public function addAjax($name,$summary="",$img)
    {
        (new CategoryAddValidate())->goCheck();
        $img_id=ImageModel::categoryAddIMG($img);
        $result=CategoryModel::add($name,$img_id,$summary);
        if (!$result) {
            throw new BaseException();
        }
        return json(new SuccessMessage());
    }

    //上传
    public function upload()
    {
       //接收文件
        $request = Request::instance();
        $img=$request->file('file');
        //1048576字节    验证图片，并移动到相应位置
        $info = $img->validate(['size'=>1048576,'ext' => 'jpg,png,jpeg'])->move(ROOT_PATH . 'public' . DS
            . 'uploads',date('Ymd').DS.'cg'.time());
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

    public function listAjax($pageIndex=1,$pageSize=15)
    {
        (new ListValidate())->goCheck();
        $categoryList=CategoryModel::getList($pageIndex,$pageSize);
        return $categoryList;
    }

    public function delAJax($id)
    {
        (new IDMustBePositiveInt())->goCheck();
        $del=CategoryModel::destroy($id);
        if (!$del) {
            throw new BaseException();
        }
        return json(new SuccessMessage(), 201);
    }

    public function delSelectAjax($ids = '')
    {
        (new IDCollection())->goCheck();
        CategoryModel::delGetIDs($ids);
        return json(new SuccessMessage(), 201);
    }
}