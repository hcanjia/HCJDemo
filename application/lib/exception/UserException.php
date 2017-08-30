<?php
/**
 * Created by PhpStorm.
 * User: HCJ
 * Date: 2017/7/22
 * Time: 13:53
 */

namespace app\lib\exception;


class UserException extends BaseException
{
    public $code=404;
    public $message='用户不存在';
    public $errorCode=60000;
}