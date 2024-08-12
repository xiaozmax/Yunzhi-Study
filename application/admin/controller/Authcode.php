<?php

namespace app\admin\controller;

use app\common\controller\Backend;
use think\Db;

/**
 *
 *
 * @icon fa fa-circle-o
 */
class Authcode extends Backend
{
    /**
     * Authcode模型对象
     * @var \app\admin\model\Authcode
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Authcode();
    }

    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */

    public function index()
    {
        // 设置过滤方法
        $this->request->filter(["strip_tags", "trim"]);
        if (false === $this->request->isAjax()) {
            return $this->view->fetch();
        }
        // 如果发送的来源是 Selectpage，则转发到 Selectpage
        if ($this->request->request("keyField")) {
            return $this->selectpage();
        }
        // 构建查询参数
        [$where, $sort, $order, $offset, $limit] = $this->buildparams();

        // 构建查询
        $query = Db::name("authcode") // 替换 'your_table_name' 为你的表名
            ->alias("t")
            ->join("user_group u", "t.classid = u.id") // 关联 user_group 表
            ->field("t.*, u.name as class_name") // 选择你的表的所有字段以及 user_group 表的 name 字段
            ->where($where)
            ->order($sort, $order);

        // 获取分页结果
        $list = $query->paginate($limit, false, [
            "query" => $this->request->get(),
        ]);

        // 获取分页后的数据
        $items = $list->items();

        // 替换 class_id 为 class_name
        foreach ($items as &$item) {
            $item["classid"] = $item["class_name"];
        }

        // 移除不需要的字段
        $result = array_map(function ($item) {
            unset($item["class_name"]);
            return $item;
        }, $items);

        // 构建最终返回的数据结构
        $result = [
            "total" => $list->total(),
            "rows" => $result,
        ];

        return json($result);
    }

    public function add()
    {
        if (false === $this->request->isPost()) {
            $groupList = Db::name("user_group")->column("name");
            $groupId = Db::name("user_group")->column("id");
            //$groupId = Db::name('user_group')->column('id');

            // 将年级列表传递给视图
            return $this->view
                ->assign("groupList", $groupList)
                ->assign("groupId", $groupId)
                ->fetch();
        }
        $params = $this->request->post("row/a");
        if (empty($params)) {
            $this->error(__("Parameter %s can not be empty", ""));
        }
        $params = $this->preExcludeFields($params);

        if ($this->dataLimit && $this->dataLimitFieldAutoFill) {
            $params[$this->dataLimitField] = $this->auth->id;
        }
        $result = false;
        Db::startTrans();
        try {
            // 是否采用模型验证
            if ($this->modelValidate) {
                $name = str_replace(
                    "\\model\\",
                    "\\validate\\",
                    get_class($this->model)
                );
                $validate = is_bool($this->modelValidate)
                    ? ($this->modelSceneValidate
                        ? $name . ".add"
                        : $name)
                    : $this->modelValidate;
                $this->model->validateFailException()->validate($validate);
            }

            // 移除ID字段，让数据库自动生成
            unset($params["id"]);

            $result = $this->model->allowField(true)->save($params);
            Db::commit();
        } catch (ValidateException | PDOException | Exception $e) {
            Db::rollback();
            $this->error($e->getMessage());
        }
        if ($result === false) {
            $this->error(__("No rows were inserted"));
        }
        $this->success();
    }

    public function edit($ids = null)
    {
        $groupList = Db::name("user_group")->column("name");
        $groupId = Db::name("user_group")->column("id");

        // 将年级列表传递给视图
        $this->view
            ->assign("groupList", $groupList)
            ->assign("groupId", $groupId);
        $row = $this->model->get($ids);
        if (!$row) {
            $this->error(__("No Results were found"));
        }
        $adminIds = $this->getDataLimitAdminIds();
        if (
            is_array($adminIds) &&
            !in_array($row[$this->dataLimitField], $adminIds)
        ) {
            $this->error(__("You have no permission"));
        }
        if (false === $this->request->isPost()) {
            $this->view->assign("row", $row);
            return $this->view->fetch();
        }
        $params = $this->request->post("row/a");
        if (empty($params)) {
            $this->error(__("Parameter %s can not be empty", ""));
        }
        $params = $this->preExcludeFields($params);
        $result = false;
        Db::startTrans();
        try {
            //是否采用模型验证
            if ($this->modelValidate) {
                $name = str_replace(
                    "\\model\\",
                    "\\validate\\",
                    get_class($this->model)
                );
                $validate = is_bool($this->modelValidate)
                    ? ($this->modelSceneValidate
                        ? $name . ".edit"
                        : $name)
                    : $this->modelValidate;
                $row->validateFailException()->validate($validate);
            }
            $result = $row->allowField(true)->save($params);
            Db::commit();
        } catch (ValidateException | PDOException | Exception $e) {
            Db::rollback();
            $this->error($e->getMessage());
        }
        if (false === $result) {
            $this->error(__("No rows were updated"));
        }
        $this->success();
    }
}
