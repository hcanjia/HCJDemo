<?php
/**
 * Created by PhpStorm.
 * User: HCJ
 * Date: 2017/8/13
 * Time: 11:36
 */

namespace app\admin\model;


class Image extends BaseModel
{
    protected $autoWriteTimestamp=true;
    protected $updateTime = false;
    protected $hidden = ['from','create_time','id'];
    public function getUrlAttr($value,$data)
    {
        return $this->prefixImgUrl($value,$data);
    }

    public static function categoryAddIMG($img)
    {
        $img=self::create(['url'=>'uploads/'.$img,'from'=>1]);
        return $img->id;
    }

}