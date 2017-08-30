<?php
/**
 * Created by PhpStorm.
 * User: HCJ
 * Date: 2017/7/18
 * Time: 8:05
 */

namespace app\api\controller\v1;


use app\api\validate\IDCollection;
use app\api\model\Theme as ThemeModel;
use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\ThemeException;

class Theme
{
    /*
     * @url /theme?ids=id1,id2,...
     * @return 一组Theme模型
     * */
    public function getSampleList($ids='')
    {
        (new IDCollection())->goCheck();
        $result = ThemeModel::getThemIDs($ids);
        if ($result->isEmpty()) {
            throw new ThemeException();
        }
        return $result;

    }
    /*
         * @url /theme/id
         * @return 主题里的列表
         * */
    public function getComplexOne($id)
    {
        (new IDMustBePositiveInt())->goCheck();
        $result = ThemeModel::getThemeWithProduct($id);
        if (!$result) {
            throw new ThemeException();
        }
        return $result;
    }
}