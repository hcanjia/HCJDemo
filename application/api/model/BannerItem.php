<?php
/**
 * Created by PhpStorm.
 * User: HCJ
 * Date: 2017/7/16
 * Time: 7:24
 */

namespace app\api\model;


use think\Model;

class BannerItem extends Model
{
    protected $hidden = ['id', 'img_id', 'delete_time', 'update_time'];

    public function img()
    {
        // 一对一关联 相对的关联
        return $this->belongsTo('image', 'img_id', 'id');

    }
}