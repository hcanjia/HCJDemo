<?php
/**
 * Created by PhpStorm.
 * User: HCJ
 * Date: 2017/7/15
 * Time: 11:13
 */

namespace app\lib\exception;


class BannerMissException extends BaseException
{
    public $code=404;
    public $msg = "请求的Banner不存在";
    public $errorCode=40000;



}