<?php

namespace app\admin\controller\xunsearch;

use app\common\controller\Backend;

/**
 * Xunsearch字段列管理
 *
 * @icon fa fa-circle-o
 */
class Fields extends Backend
{

    /**
     * Fields模型对象
     * @var \app\admin\model\xunsearch\Fields
     */
    protected $model = null;
    protected $noNeedRight = ['check_element_available'];

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\xunsearch\Fields;
        $this->view->assign("typeList", $this->model->getTypeList());
        $this->view->assign("indexList", $this->model->getIndexList());
        $this->view->assign("phraseList", $this->model->getPhraseList());
        $this->view->assign("nonBoolList", $this->model->getNonBoolList());
        $this->view->assign("statusList", $this->model->getStatusList());
    }

    /**
     * 检测元素是否可用
     * @internal
     */
    public function check_element_available()
    {
        $project_id = $this->request->request('project_id');
        $id = $this->request->request('id');
        $name = $this->request->request('name');
        $value = $this->request->request('value');
        $name = substr($name, 4, -1);
        if (!$name) {
            $this->error(__('Parameter % s can not be empty', 'name'));
        }
        if (!$project_id) {
            $this->error(__('Parameter % s can not be empty', 'project_id'));
        }
        $this->model->where('project_id', $project_id);
        if ($id) {
            $this->model->where('id', '<>', $id);
        }
        $exist = $this->model->where($name, $value)->find();
        if ($exist) {
            $this->error(__('The data already exist'));
        } else {
            $this->success();
        }
    }

}
