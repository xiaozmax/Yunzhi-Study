<?php

namespace app\admin\controller;

use app\common\controller\Backend;
use think\Db;

/**
 * @icon fa fa-circle-o
 */
class Signin extends Backend
{
    /**
     * Signin模型对象
     *
     * @var \app\admin\model\Signin
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Signin();
    }

    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改.
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
        $query = Db::name("signin") // 替换 'your_table_name' 为你的表名
            ->alias("t")
            ->join("user_group u", "t.userrange = u.id") // 关联 user_group 表
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
            $item["userrange"] = $item["class_name"];
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
                    '\\validate\\',
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
                    '\\validate\\',
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

    public function record()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $jsonData = file_get_contents("php://input");
            $dataa = json_decode($jsonData, true);
            $signinid = $dataa["id"];
            $userrange = Db::name("signin")
                ->where("sign_id", $signinid)
                ->field("userrange")
                ->find();
            $userrange = $userrange["userrange"];
            $userlist = Db::name("user")
                ->where("group_id", $userrange)
                ->select();
            $record = Db::name("signin_record")
                ->where("signinid", $signinid)
                ->select();
            // 初始化$returndat为数组
            $returndat = [];

            // 创建一个以userid为键的数组，用于快速查找签到记录
            $recordMap = [];
            foreach ($record as $item) {
                $recordMap[$item["userid"]] = $item;
            }

            // 遍历$userlist，构建所需格式的数组
            foreach ($userlist as $user) {
                $userid = $user["id"];
                // 如果存在签到记录，则使用记录中的数据
                if (isset($recordMap[$userid])) {
                    $item = $recordMap[$userid];
                    $time = isset($item["time"])
                        ? date("Y-m-d H:i:s", $item["time"])
                        : "/";
                    $ip = isset($item["ip"])
                        ? $item["ip"]
                        : $_SERVER["REMOTE_ADDR"] ?? "/";
                } else {
                    // 如果没有签到记录，则用'/'填充time和ip
                    $time = "未签到";
                    $ip = "/";
                }
                $returndat[] = [
                    "uid" => $userid,
                    "name" => $user["nickname"],
                    "time" => $time,
                    "ip" => $ip,
                ];
            }

            return json_encode($returndat);
        }

        return $this->view->fetch("record", []);
    }
}
