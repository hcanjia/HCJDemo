<?php
/**
 * Created by PhpStorm.
 * User: HCJ
 * Date: 2017/7/28
 * Time: 18:44
 */

namespace app\api\model;


use app\lib\exception\BaseException;

class Order extends BaseModel
{
    protected $hidden = ['delete_time', 'update_time'];

    //自动写入时间戳
    protected $autoWriteTimestamp = true;

    public function getSnapItemsAttr($value)
    {
        if (!$value) {
            return null;
        }
        return json_decode($value);
    }

    public function getSnapAddressAttr($value)
    {
        if (!$value) {
            return null;
        }
        return json_decode($value);
    }

    public static function getSummaryByUser($uid, $page = 1, $size = 5)
    {
       $pagingData= self::where('user_id', '=', $uid)
            ->order('create_time','desc')
            ->paginate($size,true,['page'=>$page]);
        return $pagingData;
    }
}