<?php
/**
 * Created by PhpStorm.
 * User: HCJ
 * Date: 2017/8/15
 * Time: 18:20
 */

namespace app\admin\service;


use app\lib\exception\BaseException;
use app\lib\exception\TokenException;
use app\admin\service\Token as TokenService;
use app\lib\exception\WeChatException;
use app\admin\model\Table as TableModel;

class WxCreateCode extends BaseService
{
    function __construct()
    {
        $this->wxAppID = config('wx.app_id');
        $this->wxAppSecret = config('wx.app_secret');
        //拼接向微信接口请求的Url
        $this->wxAccessToken = sprintf(config('wx.access_token'),
            $this->wxAppID, $this->wxAppSecret);

    }

    public function createCode($data,$id)
    {

        //$access_token = $access_token['access_token'];
        $accessTokenResult = TokenService::getCurrentTokenVar('access_token');

        if (!$accessTokenResult) {

            $requestAccessToken = $this->token();
            //转换为数组，方便取值
            $arrayAccessToken = json_decode($requestAccessToken,true);
            $this->saveToCache($arrayAccessToken);
            $accessTokenResult = $arrayAccessToken['access_token'];

        }

        $getWxCodeUnLimit = sprintf(config('wx.get_wx_code_un_limit'), $accessTokenResult);

        $result = curl_post($getWxCodeUnLimit, $data);

        $wxResult = json_decode($result, true);
        if (!$wxResult == null) {
            $loginFail = array_key_exists('errcode', $wxResult);
            if ($loginFail) {
                TableModel::where("id", "=", $id)->delete();
                $this->processLoginError($wxResult);
            }
        }
        return $result;
    }

    public function token()
    {
        $result = curl_get($this->wxAccessToken);
     //   $result = json_decode($result, true);
        return $result;

    }

    public function saveToCache($access_token, $user_id = 'hcj')
    {
        $key = $user_id;
        $result = cache($key, $access_token, 60);
        if (!$result) {
            throw new TokenException([
                'msg' => '服务器缓存异常',
                'errorCode' => 10005
            ]);
        }
        return true;
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