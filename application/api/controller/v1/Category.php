<?php
/**
 * Created by PhpStorm.
 * User: HCJ
 * Date: 2017/7/21
 * Time: 10:18
 */

namespace app\api\controller\v1;

use app\api\model\Category as CategoryModel;
use app\lib\exception\CategoryException;

class Category
{
    public function getAllCategory()
    {
        $categories=CategoryModel::all([],'img');

        if ($categories->isEmpty()) {
            throw new CategoryException();
        }
        return $categories;
    }
}