<?php
/**
 * Created by PhpStorm.
 * User: HCJ
 * Date: 2017/8/19
 * Time: 19:23
 */

namespace app\lib\exception;


class ReturnSuccess
{
    public function __construct($params=[])
    {
        //判断是否为数组
        if (!is_array($params)) {
            return ;
        }
        if (array_key_exists('code', $params)) {
            $this->code=$params['code'];
        }
        if (array_key_exists('msg', $params)) {
            $this->msg=$params['msg'];
        }
        if (array_key_exists('url', $params)) {
            $this->url=$params['url'];
        }
        if (array_key_exists('imgName', $params)) {
            $this->imgName=$params['imgName'];
        }

    }

    public $code=200;
    public $msg="上传成功";
    public $url = "";
    public $imgName="";

}