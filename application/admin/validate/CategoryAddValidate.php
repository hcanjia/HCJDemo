<?php
/**
 * Created by PhpStorm.
 * User: HCJ
 * Date: 2017/8/20
 * Time: 8:49
 */

namespace app\admin\validate;


class CategoryAddValidate extends BaseValidate
{
        protected $rule=[
            'name'=>'require|max:10',
            'img'=>'img'
        ];


    protected function img($value)
    {
       $ext= strtolower(pathinfo($value, PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg','png','jpeg'])) {
            return true;
        }else{
            return false;
        }
    }
}