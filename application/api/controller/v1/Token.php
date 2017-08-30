<?php
/**
 * Created by PhpStorm.
 * User: HCJ
 * Date: 2017/7/21
 * Time: 14:29
 */

namespace app\api\controller\v1;


use app\api\service\UserToken;
use app\api\validate\TokenGet;

class Token
{
    public function getToken($code='')
    {
        (new TokenGet())->goCheck();
        $tk = new UserToken($code);
        $token = $tk->get();
       return [
           'token'=>$token
       ];
    }
}