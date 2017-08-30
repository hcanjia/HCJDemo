<?php
/**
 * Created by PhpStorm.
 * User: HCJ
 * Date: 2017/7/18
 * Time: 8:05
 */

namespace app\api\model;


class Theme extends BaseModel
{
    public $hidden = ['delete_time', 'update_time', 'topic_img_id', 'head_img_id'];

    public function topicImg()
    {
        return $this->belongsTo('Image', 'topic_img_id', 'id');
    }

    public function headImg()
    {
        return $this->belongsTo('Image', 'head_img_id', 'id');
    }

    public function product()
    {
        return $this->belongsToMany('product', 'theme_product',
            'product_id', 'theme_id');
    }

    public static function getThemIDs($ids)
    {
        $ids = explode(',', $ids);
        $result = self::with('topicImg,headImg')->select($ids);
        return $result;
    }

    public static function getThemeWithProduct($id)
    {
        $theme = self::with('product,topicImg,headImg')->find($id);
        return $theme;
    }


}