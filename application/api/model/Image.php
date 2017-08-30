<?php
/**
 * Created by PhpStorm.
 * User: HCJ
 * Date: 2017/7/16
 * Time: 7:39
 */

namespace app\api\model;


class Image extends BaseModel
{
    protected $hidden = ['id', 'from', 'delete_time', 'update_time'];

    //获取器   get字段名Attr
    public function getUrlAttr($value,$data)
    {
        return $this->prefixImgUrl($value,$data);
    }

}