<?php
/**
 * Created by PhpStorm.
 * User: HCJ
 * Date: 2017/7/21
 * Time: 14:40
 */

namespace app\api\service;


use app\lib\exception\TokenException;
use app\lib\exception\WeChatException;
use think\Exception;
use app\api\model\User as UserModel;

class UserToken extends Token
{
    protected $code;
    protected $wxAppID;
    protected $wxAppSecret;
    protected $wxLoginUrl;

    function __construct($code)
    {
        $this->code = $code;
        $this->wxAppID = config('wx.app_id');
        $this->wxAppSecret = config('wx.app_secret');
        //拼接向微信接口请求的Url
        $this->wxLoginUrl = sprintf(config('wx.login_url'),
            $this->wxAppID, $this->wxAppSecret, $this->code);
    }

    public function get()
    {
        //向微信接口发送请求
        $result = curl_get($this->wxLoginUrl);
        //把微信返回的字符串转换为数组
        $wxResult = json_decode($result, true);
        if (empty($result)) {
            //数组为空返回异常
            throw new Exception('获取异常，微信内部错误');
        } else {
            //判断$wxResult数组是否存在errcode
            $loginFail = array_key_exists('errcode', $wxResult);
            if ($loginFail) {
                $this->processLoginError($wxResult);
            }
                //成功取到数据调用grantToken方法
                $token= $this->grantToken($wxResult);
                return $token;

        }


    }

    private function grantToken($wxResult)
    {
        //拿到微信返回的openid
        $openid = $wxResult['openid'];
        //在数据库中查找openid是否存在
        $user = UserModel::getByOpenID($openid);
        if ($user) {
            //存在openid，取出对应主键id
            $uid = $user->id;
        } else {
            //不存在，向数据库写入openid，并返回对应主键id
            $uid = UserModel::newUser($openid);
        }

        $cachedValue = $this->prepareCachedValue($wxResult, $uid);
        //写入缓存并返回token
        $token = $this->saveToCache($cachedValue);
        return $token;
    }

    //准备缓存
    private function prepareCachedValue($wxResult,$uid)
    {
        $cachedValue=$wxResult;
        $cachedValue['uid'] = $uid;
        $cachedValue['scope']=16;
        return $cachedValue;
    }

    //写入缓存
    public function saveToCache($cachedValue)
    {
        $key = self::generateToken();
        //$value=111;

        //如果不是json则转换为json
        $value = json_encode($cachedValue);
        $expire_in = config('setting.token_expire_in');
        $request = cache($key, $value, $expire_in);
        if (!$request) {
            throw new TokenException([
                'msg'=>'服务器缓存异常',
                'errorCode'=>10005
            ]);
        }
        return $key;
    }

    //改写微信异常
    public function processLoginError($wxResult)
    {
        throw new WeChatException([
            'msg' => $wxResult['errmsg'],
            'errorCode' => $wxResult['errcode']
        ]);
    }
}