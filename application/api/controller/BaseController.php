<?php
/**
 * Created by PhpStorm.
 * User: HCJ
 * Date: 2017/7/27
 * Time: 18:02
 */

namespace app\api\controller;


use think\Controller;
use app\api\service\Token as TokenService;

class BaseController extends Controller
{

    //调用needPrimaryScope验证权限 需要用户或者管理员权限才能访问
    protected function checkPrimaryScope()
    {
        TokenService::needPrimaryScope();
    }

    //调用needExclusiveScope验证权限 需要用户才能访问
    protected function checkExclusiveScope()
    {
        TokenService::needExclusiveScope();
    }
}