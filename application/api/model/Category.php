<?php
/**
 * Created by PhpStorm.
 * User: HCJ
 * Date: 2017/7/21
 * Time: 10:18
 */

namespace app\api\model;


class Category extends BaseModel
{
    protected $hidden = ['update_img','delete_img'];
    public function img()
    {
        return $this->belongsTo('image', 'topic_img_id', 'id');
    }

}