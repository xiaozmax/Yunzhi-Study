<?php

namespace app\admin\controller;

use app\common\controller\Backend;
use think\Db;
/**
 *
 *
 * @icon fa fa-circle-o
 */
class Questioning extends Backend
{
    /**
     * Questioning模型对象
     * @var \app\admin\model\Questioning
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Questioning();
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
        $query = Db::name("questioning") // 替换 'your_table_name' 为你的表名
            ->alias("q") // 使用不同的别名
            ->join("user u", "q.uid = u.id") // 关联 user 表
            ->join("studytask st", "q.study_taskid = st.id") // 关联 studytask 表
            ->field(
                "q.*, u.nickname as user_nickname, st.title as studytask_title"
            ) // 选择所有字段，并为关联表字段指定别名
            ->where($where)
            ->order($sort, $order);

        // 获取分页结果
        $list = $query->paginate($limit, false, [
            "query" => $this->request->get(),
        ]);

        // 获取分页后的数据
        $items = $list->items();

        // 替换 uid 为 user_nickname 和 study_taskid 为 studytask_title
        foreach ($items as &$item) {
            $item["uid"] = $item["user_nickname"];
            $item["study_taskid"] = $item["studytask_title"];
        }

        // 构建最终返回的数据结构
        $result = [
            "total" => $list->total(),
            "rows" => $items, // 直接使用$items，因为我们已经替换了相应的字段
        ];

        return json($result);
    }

    /**
     * 编辑
     *
     * @param $ids
     * @return string
     * @throws DbException
     * @throws \think\Exception
     */
    public function edit($ids = null)
    {
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

        // 从数据库中获取关联的studytask数据
        $studyTask = Db::name("studytask")
            ->where("id", $row["study_taskid"])
            ->find();
        $record = Db::name("taskrecord")
            ->where("taskid", $row["task_record_id"])
            ->find();
        if (false === $this->request->isPost()) {
            // 将questioning数据和关联的studytask数据分配到视图
            $this->view->assign("row", $row);
            $this->view->assign("studyTask", $studyTask);
            $this->view->assign("record", $record);
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
