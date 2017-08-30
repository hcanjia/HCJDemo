<?php
/**
 * Created by PhpStorm.
 * User: HCJ
 * Date: 2017/7/18
 * Time: 8:20
 */

namespace app\api\validate;


class IDCollection extends BaseValidate
{
    protected $rule = [
        'ids' => 'require|checkIDs'
    ];

    protected $message = [
        'ids' => 'ids参数必须是以逗号分隔的正整数'
    ];

    protected function checkIDs($value)
    {
        //以逗号分隔ids成一个数组
        $values = explode(',', $value);
        if (empty($values)) {
            return false;
        }
        //遍历数组 判断id是否为正整数
        foreach ($values as $id) {
            if (!$this->isPositiveInteger($id)) {
                return false;
            }
        }
        return true;
    }
}