<?php

namespace app\admin\controller;

use app\common\controller\Backend;
use think\Db;
/**
 *
 *
 * @icon fa fa-circle-o
 */
class Article extends Backend
{
    /**
     * Article模型对象
     * @var \app\admin\model\Article
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Article();
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
        $query = Db::name("article") // 替换 'your_table_name' 为你的表名
            ->alias("t")
            ->join("category u", "t.category_id = u.id") // 关联 user_group 表
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
            $item["category_id"] = $item["class_name"];
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
}
