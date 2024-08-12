<?php

namespace app\admin\controller;

use app\common\controller\Backend;
use think\Db;
use app\admin\library\Auth;
use Exception;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use think\db\exception\BindParamException;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\exception\DbException;
use think\exception\PDOException;
use think\exception\ValidateException;
use think\response\Json;
use fast\Date;
use fastadmin\controller\Web;

/**
 * 
 *
 * @icon fa fa-circle-o
 */
class Classs extends Backend
{

    /**
     * Classs模型对象
     * @var \app\admin\model\Classs
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Classs;
    }

    public function index()
    {
        //设置过滤方法
        $this->request->filter(['strip_tags', 'trim']);
        if (false === $this->request->isAjax()) {
            return $this->view->fetch();
        }
        //如果发送的来源是 Selectpage，则转发到 Selectpage
        if ($this->request->request('keyField')) {
            return $this->selectpage();
        }
        [$where, $sort, $order, $offset, $limit] = $this->buildparams();
        $list = $this->model
            ->where($where)
            ->order($sort, $order)
            ->paginate($limit);
        $result = ['total' => $list->total(), 'rows' => $list->items()];
        return json($result);
    }

    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */

     public function add()
{
    if (false === $this->request->isPost()) {
        $gradeList = Db::name('grade')->column('name');

        // 将年级列表传递给视图
        return $this->view->assign('gradeList', $gradeList)->fetch();
    }
    $params = $this->request->post('row/a');
    if (empty($params)) {
        $this->error(__('Parameter %s can not be empty', ''));
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
            $name = str_replace("\\model\\", "\\validate\\", get_class($this->model));
            $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.add' : $name) : $this->modelValidate;
            $this->model->validateFailException()->validate($validate);
        }

        // 移除ID字段，让数据库自动生成
        unset($params['id']);

        $result = $this->model->allowField(true)->save($params);
        Db::commit();
    } catch (ValidateException | PDOException | Exception $e) {
        Db::rollback();
        $this->error($e->getMessage());
    }
    if ($result === false) {
        $this->error(__('No rows were inserted'));
    }
    $this->success();
}


}
