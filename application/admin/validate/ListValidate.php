<?php
/**
 * Created by PhpStorm.
 * User: HCJ
 * Date: 2017/8/13
 * Time: 14:56
 */

namespace app\admin\validate;


class ListValidate extends BaseValidate
{
    protected $rule = [
        'pageIndex'=>'require|isPositiveInteger',
        'pageSize'=>'require|isPositiveInteger'
    ];

    protected $message=[
        'pageIndex'=>'页数必须为正整数',
        'pageSize'=>'数量必须为正整数'
    ];
}