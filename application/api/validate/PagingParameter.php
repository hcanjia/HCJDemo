<?php
/**
 * Created by PhpStorm.
 * User: HCJ
 * Date: 2017/8/7
 * Time: 20:30
 */

namespace app\api\validate;


class PagingParameter extends BaseValidate
{
    protected $rule=[
        'page'=>'isPositiveInteger',
        'size'=>'isPositiveInteger'
    ];

    protected $message=[
        'page'=>'分页参数必须是正整数',
        'size'=>'分页参数必须是正整数'
    ];
}