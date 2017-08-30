<?php
/**
 * Created by PhpStorm.
 * User: HCJ
 * Date: 2017/8/4
 * Time: 13:12
 */

namespace app\api\service;


use app\lib\enum\OrderStatusEnum;
use app\lib\exception\OrderException;
use app\lib\exception\TokenException;
use think\Exception;
use app\api\service\Order as OrderService;
use app\api\model\Order as OrderModel;
use app\api\service\Token as TokenService;
use think\Loader;
use think\Log;

Loader::import('WxPay.WxPay', EXTEND_PATH, '.Api.php');


class Pay
{
    private $orderID;
    private $orderNO;

    function __construct($orderID)
    {
        if (!$orderID) {
            throw new Exception('订单号不许为空');
        }
        $this->orderID = $orderID;
    }

    public function pay()
    {
        //检测订单
        $this->checkOrderValid();


        $orderService = new OrderService();
        $status = $orderService->checkOrderStock($this->orderID);
        //        库存检测
        if (!$status['pass']) {
            return $status;
        }
        return $this->makeWxPreOrder($status['orderPrice']);
    }

    //封装微信支付所需数据
    private function makeWxPreOrder($totalPrice)
    {
        $openid = TokenService::getCurrentTokenVar('openid');
        if (!$openid) {
            throw new TokenException();
        }
        $wxOrderData = new \WxPayUnifiedOrder();
        $wxOrderData->SetOut_trade_no($this->orderNO);
        $wxOrderData->SetTrade_type('JSAPI');
        $wxOrderData->SetTotal_fee($totalPrice);
        $wxOrderData->SetBody('小小小店铺');
        $wxOrderData->SetOpenid($openid);
        $wxOrderData->SetNotify_url(config('secure.pay_back_url'));
        return $this->getPaySignature($wxOrderData);
    }


    private function getPaySignature($wxOrderData)
    {
//        微信sdk把封装的数据发送到微信Api接口
        $wxOrder = \WxPayApi::unifiedOrder($wxOrderData);
        if ($wxOrder['return_code'] != 'SUCCESS' ||
            $wxOrder['result_code'] != 'SUCCESS') {
            Log::record($wxOrder, 'error');
            Log::record('获取预订单失败','error');
        }
        //prepay_id
        $this->recordPreOrder($wxOrder);


        $signature = $this->sign($wxOrder);
        return $signature;
    }


    //写入数据库订单微信支付的预订单id
    private function recordPreOrder($wxOrder)
    {
        OrderModel::where('id','=',$this->orderID)
            ->update(['prepay_id' => $wxOrder['prepay_id']]);
    }

    //签名
    private function sign($wxOrder)
    {
        $jsApiPayData = new \WxPayJsApiPay();
        $jsApiPayData->SetAppid(config('wx.app_id'));
        $jsApiPayData->SetTimeStamp((string)time());

        $rand = md5(time() . mt_rand(0, 9999));
        $jsApiPayData->SetNonceStr($rand);
        $jsApiPayData->SetPackage('prepay_id='.$wxOrder['prepay_id']);
        $jsApiPayData->SetSignType('md5');
        $sign = $jsApiPayData->MakeSign();

        $rawValues = $jsApiPayData->GetValues();
        $rawValues['paySign']=$sign;
        unset($rawValues['appId']);

        return $rawValues;

    }

    private function checkOrderValid()
    {
        $order = OrderModel::where(');id', '=', $this->orderID)->find();

        //订单号是否存在
        if (!$order) {
            throw new OrderException();
        }

        //订单uid是否跟token里的uid匹配
        if (!TokenService::isValidOperate($order->user_id)) {
            throw new TokenException([
                'msg' => '订单与用户不匹配',
                'errorCode' => 10003
            ]);
        }

        //订单是否已经支付过
        if ($order->status != OrderStatusEnum::UNPAID) {
            throw new OrderException([
                'msg' => '订单已支付过啦',
                'errorCode' => 80003,
                'code' => 400
            ]);
        }
        $this->orderNO = $order->user_no;
        return true;
    }
}