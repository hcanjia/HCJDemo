<?php
/**
 * Created by PhpStorm.
 * User: HCJ
 * Date: 2017/7/22
 * Time: 9:29
 */

namespace app\api\model;


class ProductImage extends BaseModel
{
    protected $hidden = ['id','delete_time','product_id'];
    public function imgUrl()
    {
        return $this->belongsTo('Image', 'img_id', 'id');
    }
}