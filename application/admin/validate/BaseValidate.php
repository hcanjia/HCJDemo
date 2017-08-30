<?php
/**
 * Created by PhpStorm.
 * User: HCJ
 * Date: 2017/7/25
 * Time: 16:20
 */

namespace app\admin\validate;


use app\lib\exception\ParameterException;
use think\Request;
use think\Validate;

class BaseValidate extends Validate
{
    public function goCheck()
    {
        $request = Request::instance();
        $params = $request->param();
        $result = $this->batch()->check($params);
        if (!$result) {
            throw new ParameterException([
                'msg'=>$this->error
            ]);
        } else {
            return true;
        }
    }



    protected function isNotEmpty($value)
    {
        if(empty($value)){
            return false;
        }else{
            return true;
        }
    }
    protected function isPositiveInteger($value)
    {
        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
            return true;
        }else{
            return false;
        }
    }


}