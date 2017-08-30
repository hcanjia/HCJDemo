<?php
/**
 * Created by PhpStorm.
 * User: HCJ
 * Date: 2017/7/25
 * Time: 10:06
 */

namespace app\admin\controller;


class Index extends BaseController
{
    public function index()
    {
        return $this->fetch();
    }

    public function main()
    {
        return $this->fetch();
    }

    public function navJs()
    {
        return $this->fetch();
    }
}