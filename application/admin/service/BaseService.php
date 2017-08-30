<?php
/**
 * Created by PhpStorm.
 * User: HCJ
 * Date: 2017/8/18
 * Time: 19:18
 */

namespace app\admin\service;


class BaseService
{
    public static function createIMGName($Suffix='',$classify='')
    {
        $name =$classify. date('Ymd') . time();
        return $name . $Suffix;
    }
}