<?php
/**
 * Created by PhpStorm.
 * User: HCJ
 * Date: 2017/7/21
 * Time: 16:24
 */

namespace app\lib\exception;


class WeChatException extends BaseException
{
    public $code=400;
    public $msg='微信服务器接口调用失败';
    public $errorCode = 999;
}