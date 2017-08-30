<?php
/**
 * Created by PhpStorm.
 * User: HCJ
 * Date: 2017/7/15
 * Time: 9:56
 */

namespace app\api\model;


use think\Model;

class Banner extends Model
{
    protected $hidden = ['delete_time', 'update_time'];

    public function items()
    {
        //hasMany 一对多关联      关联模型   关联外键   当前主键
        return $this->hasMany('BannerItem', 'banner_id', 'id');
    }

    public static function getBannerByID($id)
    {
        $banner = self::with(['items', 'items.img'])->find($id);
        return $banner;
    }
}