<?php
/**
 * Created by PhpStorm.
 * User: HCJ
 * Date: 2017/7/21
 * Time: 15:17
 */

return [
    'app_id' => 'wxf84bed23a25ec712',
    'app_secret' => '6d4a158d4e848f6612de42503e1d81e7',
    'login_url' => 'https://api.weixin.qq.com/sns/jscode2session?appid=%s&secret=%s&js_code=%s&grant_type=authorization_code',
    'access_token' =>'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=%s&secret=%s',
    'get_wx_code_un_limit'=>'https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=%s'
];