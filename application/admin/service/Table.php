<?php
/**
 * Created by PhpStorm.
 * User: HCJ
 * Date: 2017/8/11
 * Time: 18:38
 */

namespace app\admin\service;


use app\admin\model\Table as TableModel;
use app\lib\exception\BaseException;
use app\lib\exception\WeChatException;
use think\Loader;
use app\admin\model\Image as ImageModel;

//Loader::import('phpqrcode/qrlib', EXTEND_PATH, '.php');

class Table extends BaseService
{
    //添加桌位
    public function addTableResult($tableName)
    {
        $tableData = new TableModel();
        $tableData->name = $tableName;
        $tableData->save();
        $id = $tableData->id;
        $result = $this->createQRCode($tableName, $id);
        return $result;

    }
//生成图片名


    //生成二维码
    public function createQRCode($tableName, $id)
    {
        $imgName = $this->createIMGName('.png');
        $data = ['scene' => $id . "&" . $tableName];
        $data = json_encode($data);
        //调用微信接口
        $wxCreateCode=new WxCreateCode();
        $result = $wxCreateCode->createCode($data,$id);

        $filePath = ROOT_PATH . 'public' . DS . 'uploads\/' . $imgName;

       //图片流保存为图片
        $writeIMG = file_put_contents($filePath, $result);
        if (!$writeIMG) {
            throw new BaseException();
        }

        $imageModel = new ImageModel();
        $imageModel->url = "uploads/" . $imgName;
        $imageModel->from = 1;
        $imageModel->save();
        $result=TableModel::where("id", "=", $id)->update(["img_id" => $imageModel->id]);
        if (!$result) {
            throw new BaseException([
                'msg'=>'error'
            ]);
        }
        return $result;

    }



}