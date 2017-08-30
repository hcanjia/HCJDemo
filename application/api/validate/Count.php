<?php
/**
 * Created by PhpStorm.
 * User: HCJ
 * Date: 2017/7/20
 * Time: 8:42
 */

namespace app\api\validate;


class Count extends BaseValidate
{
    public $rule = [
        'count'=>'isPositiveInteger|between:1,15'
    ];

}