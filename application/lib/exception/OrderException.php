<?php
/**
 * Created by PhpStorm.
 * User: HCJ
 * Date: 2017/7/28
 * Time: 11:43
 */

namespace app\lib\exception;


class OrderException extends BaseException
{
    public $code=404;
    public $msg='订单不存在，请检查ID';
    public $errorCode=80000;
}