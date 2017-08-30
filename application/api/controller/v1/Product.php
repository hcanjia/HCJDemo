<?php
/**
 * Created by PhpStorm.
 * User: HCJ
 * Date: 2017/7/20
 * Time: 8:39
 */

namespace app\api\controller\v1;


use app\api\validate\Count;
use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\CategoryException;
use app\lib\exception\ParameterException;
use app\lib\exception\ProductException;
use app\api\model\Product as ProductModel;

class Product
{
    //获取最佳新品
    public function getRecent($count = 15)
    {
        (new Count())->goCheck();
        $product = ProductModel::getMostRecent($count);
        if ($product->isEmpty()) {
            throw new ProductException();
        }

        return $product;
    }

    //获取分类所有商品
    public function getAllInCategory($id)
    {
        (new IDMustBePositiveInt())->goCheck();
        $products = ProductModel::getProductsByCategory($id);
        if ($products->isEmpty()) {
            throw new ParameterException();
        }
        return $products;
    }

    //获取商品详情
    public function getOne($id)
    {
        (new IDMustBePositiveInt())->goCheck();
        $product = ProductModel::getProductDetail($id);
        if (!$product) {
            throw new ProductException();
        }
        return $product;

    }
}