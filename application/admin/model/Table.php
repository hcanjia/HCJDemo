<?php
/**
 * Created by PhpStorm.
 * User: HCJ
 * Date: 2017/7/25
 * Time: 16:29
 */

namespace app\admin\model;

use app\admin\service\Table as TableService;
use app\lib\exception\BaseException;
use think\Cache;
use traits\model\SoftDelete;
use Workerman\Protocols\HttpCache;

class Table extends BaseModel
{
    protected $autoWriteTimestamp=true;
    use SoftDelete;
    protected $hidden=['img_id','key','update_time','delete_time'];
    public function img()
    {
        return $this->belongsTo('image','img_id','id');
    }

    public function getImgAttr($value)
    {
        if ($value == null) {
            $finaUrl=['url'=>config('setting.admin_img_prefix').'admin\images\0.jpg'];
            return $finaUrl;
        }
        return $value;
    }

    public function getRemarksAttr($value)
    {
        if ($value==null){
            return "无";
        }
        return $value;
    }



    public static function addTable($tableName)
    {
        $table = new TableService();
        $result=$table->addTableResult($tableName);
        return $result;

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