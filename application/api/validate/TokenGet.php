<?php
/**
 * Created by PhpStorm.
 * User: HCJ
 * Date: 2017/7/21
 * Time: 14:31
 */

namespace app\api\validate;


class TokenGet extends BaseValidate
{
    protected $rule=[
        'code'=>'require|isNotEmpty'
    ];

    protected $message = [
        'code' =>'code为空，获取token失败'
    ];
}