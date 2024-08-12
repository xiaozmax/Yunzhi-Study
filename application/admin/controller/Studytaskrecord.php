<?php

namespace app\admin\controller;

use app\common\controller\Backend;
use think\Db;

/**
 * 
 *
 * @icon fa fa-circle-o
 */
class Studytaskrecord extends Backend
{

    /**
     * Studytaskrecord模型对象
     * @var \app\admin\model\Studytaskrecord
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Studytaskrecord;

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
         $query = Db::name("studytaskrecord") // 替换 'your_table_name' 为你的表名
             ->alias("q") // 使用不同的别名
             ->join("user u", "q.uid = u.id") // 关联 user 表
             ->join("studytask st", "q.study_taskid = st.id") // 关联 studytask 表
             ->field("q.*, u.nickname as user_nickname, st.title as studytask_title") // 选择所有字段，并为关联表字段指定别名
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
             $item["uidn"] = $item["user_nickname"];
             $item["study_taskidt"] = $item["studytask_title"];
         }
 
         // 构建最终返回的数据结构
         $result = [
             "total" => $list->total(),
             "rows" => $items, // 直接使用$items，因为我们已经替换了相应的字段
         ];
 
         return json($result);
     }

}
