<?php
/**
 * Created by PhpStorm.
 * User: HCJ
 * Date: 2017/7/21
 * Time: 10:31
 */

namespace app\lib\exception;


class CategoryException extends BaseException
{
    public $code=404;
    public $msg = '指定商品类目不存在，请检查商品id';
    public $errorCode=20000;
}