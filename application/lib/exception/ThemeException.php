<?php
/**
 * Created by PhpStorm.
 * User: HCJ
 * Date: 2017/7/18
 * Time: 10:59
 */

namespace app\lib\exception;


class ThemeException extends BaseException
{
    public $code=404;
    public $msg = '指定主题不存在';
    public $errorCode=30000;
}