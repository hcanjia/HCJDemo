<?php
/**
 * Created by PhpStorm.
 * User: HCJ
 * Date: 2017/7/21
 * Time: 19:25
 */

namespace app\lib\exception;


class TokenException extends BaseException
{
    public $code=401;
    public $msg='Token过期或者无效';
    public $errorCode=10001;
}