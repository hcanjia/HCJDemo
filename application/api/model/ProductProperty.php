<?php
/**
 * Created by PhpStorm.
 * User: HCJ
 * Date: 2017/7/22
 * Time: 9:31
 */

namespace app\api\model;


class ProductProperty extends BaseModel
{
    protected $hidden = ['id','delete_time', 'update_time', 'product_id'];
}