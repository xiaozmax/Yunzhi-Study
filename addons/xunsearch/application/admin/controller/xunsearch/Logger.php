<?php

namespace app\admin\controller\xunsearch;

use addons\xunsearch\library\Xunsearch;
use app\common\controller\Backend;
use think\Db;
use think\exception\PDOException;

/**
 * Xunsearch搜索词
 *
 * @icon fa fa-circle-o
 */
class Logger extends Backend
{

    protected $model = null;
    protected $project = null;

    public function _initialize()
    {
        parent::_initialize();
        $project_id = $this->request->request('project_id');
        if (!$project_id) {
            $this->error("请从项目管理页面进入");
        }
        $project = \app\admin\model\xunsearch\Project::get($project_id);
        if (!$project) {
            $this->error("未找到指定的项目");
        }
        $this->project = $project;

    }

    /**
     * 查看
     */
    public function index()
    {
        //设置过滤方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax()) {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField')) {
                return $this->selectpage();
            }
            $offset = $this->request->get('offset', 0);
            $query = $this->request->get('search', '');
            $limit = $this->request->get('limit', 10);
            $total = 0;
            $list = [];
            try {
                $xs = new \XS($this->project->name);
                $xs->setScheme(\XSFieldScheme::logger());
                $result = $xs->search->setDb(\XSSearch::LOG_DB)->setLimit($limit, $offset)->search($query ?: 'total:1');
                $total = $xs->search->getLastCount();

                foreach ($result as $index => $item) {
                    $list[] = ['id' => $item->docid(), 'word' => $item->body, 'nums' => $item->total, 'result' => 0];
                }

            } catch (\XSException $e) {
                $this->error("请检查是否生成项目配置");
            }
            $result = array("total" => $total, "rows" => $list);
            return json($result);
        }
        $this->assignconfig('project_url', $this->project->url);
        return $this->view->fetch();
    }

    public function add()
    {
        if ($this->request->isPost()) {
            $row = $this->request->post("row/a", []);
            $word = $row['word'] ?? '';
            $nums = $row['nums'] ?? 1;
            if (!$word || !$nums) {
                $this->error("搜索词和搜索次数不能为空");
            }
            try {
                $xs = new \XS($this->project->name);
                $xs->setScheme(\XSFieldScheme::logger());
                $xs->index->setDb(\XSSearch::LOG_DB)->flushLogging();
                $search = $xs->search;
                $search->setDb(\XSSearch::LOG_DB)->setQuery('dummy');
                $search->setTimeout(0);
                $search->addSearchLog($word, $nums);
            } catch (\Exception $e) {
                $this->error("请检查是否生成项目配置");
            }
            $xs->index->setDb(\XSSearch::LOG_DB)->flushIndex();
            $xs->index->setDb(\XSSearch::LOG_DB)->flushLogging();
            usleep(150000);
            $this->success("添加搜索词成功");
        }
        return parent::add();
    }

    public function edit($ids = null)
    {
        $ids = $this->request->request('ids');

        try {
            $xs = new \XS($this->project->name);
            $xs->setScheme(\XSFieldScheme::logger());
            $search = $xs->search;
            $search->setDb(\XSSearch::LOG_DB)->setQuery('dummy');
            $search->setTimeout(0);
        } catch (\Exception $e) {
            $this->error("请检查是否生成项目配置");
        }

        $docs = $search->setQuery(null)->addQueryTerm('id', $ids)->search();
        if (!isset($docs[0])) {
            $this->error("未找到指定的搜索词");
        }
        if ($this->request->isPost()) {
            $row = $this->request->post("row/a", []);
            $word = $row['word'] ?? '';
            $nums = $row['nums'] ?? 0;
            if (!$word) {
                $this->error("搜索词和搜索次数不能为空");
            }
            $search->addSearchLog($word, $nums);
            $xs->index->setDb(\XSSearch::LOG_DB)->flushIndex();
            $xs->index->setDb(\XSSearch::LOG_DB)->flushLogging();
            usleep(150000);
            $this->success("修改搜索词成功");
        }
        $row = ['project_id' => $this->project->id, 'word' => $ids, 'nums' => $docs[0]->total];
        $this->view->assign("row", $row);
        return $this->view->fetch();
    }

    /**
     * 删除
     */
    public function del($ids = "")
    {
        $ids = $this->request->post("ids");
        if ($ids) {
            $ids = explode(',', $ids);
            try {
                $xs = new \XS($this->project->name);
                $xs->setScheme(\XSFieldScheme::logger());
                $xs->index->setDb(\XSSearch::LOG_DB)->del($ids, 'id')->flushIndex();
                $xs->index->setDb(\XSSearch::LOG_DB)->flushLogging();
                usleep(150000);
            } catch (\XSException $e) {
                $this->error("请检查是否生成项目配置");
            }
            $this->success();
        }
        $this->error(__('Parameter %s can not be empty', 'ids'));
    }

}
