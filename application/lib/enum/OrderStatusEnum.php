<?php
/**
 * Created by PhpStorm.
 * User: HCJ
 * Date: 2017/8/4
 * Time: 14:40
 */

namespace app\lib\enum;


class OrderStatusEnum
{
    //待支付
    const UNPAID=1;

    //已支付
    const PAID=2;

    //已发货
    const DELIVERED = 3;

    //已支付，但库存不足
    const PAID_BUT_OUT_OF=4;
}