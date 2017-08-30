<?php
/**
 * Created by PhpStorm.
 * User: HCJ
 * Date: 2017/7/25
 * Time: 16:18
 */

namespace app\admin\validate;


class NameMust extends BaseValidate
{
    protected $rule =[
        'tableName'=>'require|isNotEmpty|number'
    ];

}