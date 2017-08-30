<?php
/**
 * Created by PhpStorm.
 * User: HCJ
 * Date: 2017/8/20
 * Time: 9:12
 */

namespace app\admin\model;


class Category extends BaseModel
{
    protected $autoWriteTimestamp=true;
    protected $hidden = ['create_time','update_time','delete_time','topic_img_id'];
//hcj
    public static function add ($name,$img_id,$summary="")
    {
        $result=self::create(['name'=>$name,'topic_img_id'=>$img_id,'summary'=>$summary]);
        return $result;
    }

    public function img()
    {
        return $this->belongsTo('image','topic_img_id','id');
    }

}