<?php
/**
 * Created by PhpStorm.
 * User: HCJ
 * Date: 2017/7/14
 * Time: 21:05
 */

namespace app\api\controller\v1;


use app\api\validate\IDMustBePositiveInt;
use app\api\model\Banner as BannerModel;
use app\lib\exception\BannerMissException;
use app\lib\exception\BaseException;

class Banner
{
    /*
     *
     * */
    public function getBanner($id)
    {
        (new IDMustBePositiveInt())->goCheck();

        $banner = BannerModel::getBannerByID($id);
        if (!$banner) {
            throw new BannerMissException();
        }
        return $banner;

    }
}