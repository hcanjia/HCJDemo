<?php
/**
 * Created by PhpStorm.
 * User: HCJ
 * Date: 2017/7/25
 * Time: 13:35
 */

namespace app\admin\controller;


use app\admin\model\Table as TableModel;
use app\admin\validate\IDCollection;
use app\admin\validate\ListValidate;
use app\admin\validate\NameMust;
use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\BaseException;
use app\lib\exception\SuccessMessage;


class Table extends BaseController
{
    public function table()
    {
        return $this->fetch();
    }

    public function add()
    {
        //
        return $this->fetch();
    }

    public function addAjax($tableName)
    {

        (new NameMust())->goCheck();

        TableModel::addTable($tableName);

        return json(new SuccessMessage(), 201);

    }

    public function listAjax($pageIndex = 1, $pageSize = 15)
    {
        (new ListValidate())->goCheck();
        $result = TableModel::getList($pageIndex, $pageSize);
        if ($result->isEmpty()) {
            $msg = ["msg" => 'asasas'];
            return [
                'data' => [],
                'total' => 0,
                'msg' => [$msg]
            ];
        }
        return $result;
    }

    public function delAJax($id)
    {
        (new IDMustBePositiveInt())->goCheck();
        TableModel::destroy($id);
        return json(new SuccessMessage(), 201);
    }

    public function delSelectAjax($ids = '')
    {
        (new IDCollection())->goCheck();
        TableModel::delGetIDs($ids);
    }
}