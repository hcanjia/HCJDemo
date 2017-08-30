<?php
/**
 * Created by PhpStorm.
 * User: HCJ
 * Date: 2017/7/21
 * Time: 14:39
 */

namespace app\api\model;


class User extends BaseModel
{
    public function address()
    {
        return $this->hasOne('UserAddress','user_id','id');
    }


    public static function getByOpenID($openid)
    {
        $user = self::where('openid', '=', $openid)
        ->find();
        return $user;
    }

    public static function newUser($openid)
    {
        $user=self::create([
            'openid' => $openid
        ]);
        return $user->id;
    }
}