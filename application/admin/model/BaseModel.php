<?php
/**
 * Created by PhpStorm.
 * User: HCJ
 * Date: 2017/7/25
 * Time: 16:19
 */

namespace app\admin\model;


use app\lib\exception\BaseException;
use think\Model;

class BaseModel extends Model
{
    protected function prefixImgUrl($value, $data)
    {
        $finaUrl = $value;
        if ($data['from'] == 1) {

            $finaUrl = config('setting.admin_img_prefix') . $value;
        }

        return $finaUrl;
    }

    public static function getList($pageIndex,$pageSize)
    {
        $count=self::count();
        $pageData = self::with('img')->paginate($pageSize,$count,['page'=>$pageIndex]);
        return $pageData;
    }

    public static function delGetIDs($ids)
    {
        $ids = explode(',', $ids);
        $result=self::destroy($ids);
        if (!$result) {
            throw new BaseException();
        }
        return true;
    }
}