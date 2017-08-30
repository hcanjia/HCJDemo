<?php
/**
 * Created by PhpStorm.
 * User: HCJ
 * Date: 2017/7/26
 * Time: 10:17
 */

namespace app\lib\exception;


class ForbiddenException extends BaseException
{
    public $code=403;
    public $msg='权限不够，禁止访问';
    public $errorCode=10001;
}