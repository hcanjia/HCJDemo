<?php
/**
 * Created by PhpStorm.
 * User: HCJ
 * Date: 2017/7/18
 * Time: 8:07
 */

namespace app\api\model;


class Product extends BaseModel
{
    public $hidden = ['delete_time', 'category_id', 'create_time', 'update_time', 'pivot', 'from'];

    public function getMainImgUrlAttr($value, $data)
    {
        return $this->prefixImgUrl($value, $data);
    }

    public function imgs()
    {
        return $this->hasMany('ProductImage','product_id','id');
    }

    public function Properties()
    {
        return $this->hasMany('ProductProperty', 'product_id', 'id');
    }

    public static function getMostRecent($count)
    {

        $products = self::limit($count)
            ->order('create_time desc')
            ->select();
        $products = $products->hidden(['summary']);

        return $products;
    }

    public static function getProductsByCategory($categoryID)
    {
        $products = self::where('category_id', '=', $categoryID)
            ->select();
        return $products;
    }

    public static function getProductDetail($id)
    {
        $product = self::with([
            'imgs'=> function ($query) {
                $query->with(['imgUrl'])
                    ->order('order', 'asc');
            }
        ])
            ->with(['properties'])
            ->find($id);
        return $product;
    }
}