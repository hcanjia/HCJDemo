<?php
/**
 * Created by PhpStorm.
 * User: HCJ
 * Date: 2017/8/5
 * Time: 14:24
 */

namespace app\api\service;

use app\api\model\Product;
use app\lib\enum\OrderStatusEnum;
use think\Db;
use think\Exception;
use think\Loader;
use app\api\model\Order as OrderModel;
use app\api\service\Order as OrderService;
use think\Log;

Loader::import('WxPay.WxPay', EXTEND_PATH, '.Api.php');

class WxNotify extends \WxPayNotify
{

//返回结果参考
    /*<xml>
    <appid><![CDATA[wx2421b1c4370ec43b]]></appid>
    <attach><![CDATA[支付测试]]></attach>
    <bank_type><![CDATA[CFT]]></bank_type>
    <fee_type><![CDATA[CNY]]></fee_type>
    <is_subscribe><![CDATA[Y]]></is_subscribe>
    <mch_id><![CDATA[10000100]]></mch_id>
    <nonce_str><![CDATA[5d2b6c2a8db53831f7eda20af46e531c]]></nonce_str>
    <openid><![CDATA[oUpF8uMEb4qRXf22hE3X68TekukE]]></openid>
    <out_trade_no><![CDATA[1409811653]]></out_trade_no>
    <result_code><![CDATA[SUCCESS]]></result_code>
    <return_code><![CDATA[SUCCESS]]></return_code>
    <sign><![CDATA[B552ED6B279343CB493C5DD0D78AB241]]></sign>
    <sub_mch_id><![CDATA[10000100]]></sub_mch_id>
    <time_end><![CDATA[20140903131540]]></time_end>
    <total_fee>1</total_fee>
    <trade_type><![CDATA[JSAPI]]></trade_type>
    <transaction_id><![CDATA[1004400740201409030005092168]]></transaction_id>
    </xml>*/
    //解析返回结果
    public function NotifyProcess($data, &$msg)
    {
        if ($data['result_code' == 'SUCCESS']) {
            $orderNo = $data['out_trade_no'];
            Db::startTrans();
            try {
                $order = OrderModel::Where('order_no', '=', $orderNo);
                //查询订单状态
                $service = new OrderService();
                $stockStatus = $service->checkOrderStock($order->id);
                //在订单状态判断是否有库存
                if ($stockStatus['pass']) {
                    $this->updateOrderStatus($order->id,true);
                    $this->reduceStock($stockStatus);
                } else {
                    $this->updateOrderStatus($order->id,false);
                }
                Db::commit();
                return true;
            } catch (Exception $e) {
                Db::rollback();
                Log::record($e, 'error');
                return false;
            }
        } else {
            return true;
        }
    }

    //削减库存量
    private function reduceStock($stockStatus)
    {
        foreach ($stockStatus['pStatusArray'] as $singlePStatus )

            Product::where('id', '=', $singlePStatus['id'])
                ->setDec('stock', $singlePStatus['count']);
    }

    //更新订单支付状态
    private function updateOrderStatus($orderID, $success)
    {
        //三元表达式判断
        $status = $success ?
            OrderStatusEnum::PAID :
            OrderStatusEnum::PAID_BUT_OUT_OF;
        OrderModel::where('id', '=', $orderID)
            ->update(['status' => $status]);
    }
}