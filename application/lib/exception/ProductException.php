<?php
/**
 * Created by PhpStorm.
 * User: HCJ
 * Date: 2017/7/20
 * Time: 8:55
 */

namespace app\lib\exception;


class ProductException extends BaseException
{
    public $code=404;
    public $msg='指定产品不存在，请检查参数';
    public $errorCode='30000';
}