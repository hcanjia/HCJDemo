<?php
/**
 * Created by PhpStorm.
 * User: HCJ
 * Date: 2017/8/16
 * Time: 15:20
 */

namespace app\admin\service;


use think\Cache;

class Token extends BaseService
{
    public static function getCurrentTokenVar($key)
    {
        $user_id = 'hcj';
        $vars = Cache::get($user_id);
        if (!$vars) {
            return false;
        }

        $varKey=array_key_exists($key, $vars);

        if (!$varKey) {
            return false;
        }


        return $vars[$key];

    }
}