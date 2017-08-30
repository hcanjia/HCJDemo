<?php
/**
 * Created by PhpStorm.
 * User: HCJ
 * Date: 2017/7/15
 * Time: 17:23
 */

namespace app\lib\exception;


class ParameterException extends BaseException
{
    public $code =400;
    public $msg="参数错误";
    public $errorCode =10000;
}