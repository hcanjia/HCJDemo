<?php
/**
 * Created by PhpStorm.
 * User: HCJ
 * Date: 2017/7/16
 * Time: 9:54
 */

namespace app\api\model;


use think\Model;

class BaseModel extends Model
{
    protected function prefixImgUrl($value, $data)
    {
        $finaUrl = $value;
        if ($data['from'] == 1) {

            $finaUrl = config('setting.img_prefix') . $value;
        }
        return $finaUrl;
    }
}