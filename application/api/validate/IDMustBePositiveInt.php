<?php
/**
 * Created by PhpStorm.
 * User: HCJ
 * Date: 2017/7/14
 * Time: 21:49
 */

namespace app\api\validate;

class IDMustBePositiveInt extends BaseValidate
{
    protected $rule = [
        'id' => 'require|isPositiveInteger'
    ];

    protected $message = [
        'id' => 'id必须为正整数',

    ];
    //自定义验证规则

}
