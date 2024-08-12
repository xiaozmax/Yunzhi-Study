<?php

namespace app\admin\controller\xunsearch;

use addons\xunsearch\library\Xunsearch;
use app\common\controller\Backend;
use think\Cache;
use think\Config;

/**
 * Xunsearch配置管理
 *
 * @icon fa fa-circle-o
 */
class Project extends Backend
{

    /**
     * Xunsearch模型对象
     * @var \app\admin\model\xunsearch\Project
     */
    protected $model = null;
    protected $noNeedRight = ['check_element_available'];

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\xunsearch\Project;
        $this->view->assign("statusList", $this->model->getStatusList());
    }

    public function index()
    {
        //加载重置的Hooks
        $hooks = Cache::get('hooks', []);
        $resetHooks = isset($hooks['xunsearch_index_reset']) ? $hooks['xunsearch_index_reset'] : [];
        //设置过滤方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax()) {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField')) {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $total = $this->model
                ->where($where)
                ->order($sort, $order)
                ->count();

            $list = $this->model
                ->where($where)
                ->order($sort, $order)
                ->limit($offset, $limit)
                ->select();

            $list = collection($list)->toArray();
            foreach ($list as $index => &$item) {
                $item['isreset'] = 0;
                $className = '\\addons\\' . $item['name'] . '\\' . ucfirst($item['name']);
                if (in_array($className, $resetHooks)) {
                    $item['isreset'] = 1;
                }

                $connection = @fsockopen('127.0.0.1', $item['serverindex']);
                if (is_resource($connection)) {
                    $item['indexstatus'] = true;
                    fclose($connection);
                } else {
                    $item['indexstatus'] = false;
                }
                $connection = @fsockopen('127.0.0.1', $item['serversearch']);
                if (is_resource($connection)) {
                    $item['searchstatus'] = true;
                    fclose($connection);
                } else {
                    $item['searchstatus'] = false;
                }
            }
            $result = array("total" => $total, "rows" => $list);
            return json($result);
        }
        return $this->view->fetch();
    }

    /**
     * 加载配置
     */
    public function config()
    {
        $config = get_addon_config('xunsearch');
        $data = \think\Hook::listen('xunsearch_config_init');
        foreach ($data as $index => $configs) {
            foreach ($configs as $item) {
                $exist = \app\admin\model\xunsearch\Project::getByName($item['name']);
                if ($exist) {
                    continue;
                }
                $item['serverindex'] = $config['defaultserverindex'];
                $item['serversearch'] = $config['defaultserversearch'];
                $item['charset'] = isset($item['charset']) ? $item['charset'] : $config['defaultcharset'];
                $item['isaddon'] = 1;
                $item['status'] = 'normal';
                $project = \app\admin\model\xunsearch\Project::create($item, true);
                foreach ($item['fields'] as &$field) {
                    $field['project_id'] = $project->id;
                    $field['index'] = isset($field['index']) ? $field['index'] : 'none';
                    $field['status'] = 'normal';
                    $field = array_filter($field);
                    \app\admin\model\xunsearch\Fields::create($field, true);
                }
            }
        }
        $this->success("加载成功");
    }

    /**
     * 重置索引库
     */
    public function reset()
    {
        $project_id = $this->request->request('project_id');
        $row = $this->model->get($project_id);
        if (!$row) {
            $this->error("未找到指定项目");
        }
        //将后缀设置为HTML，避免新生成的URL不带HTML
        Config::set('url_html_suffix', 'html');

        set_time_limit(0);
        $index = Xunsearch::instance($row['name'])->getXS()->getIndex();
        //关闭之前的索引，避免中途有关闭的情况
        $index->stopRebuild();
        //清空索引
        //$index->clean();
        //开始重置索引
        $index->beginRebuild();

        try {
            \think\Hook::listen('xunsearch_index_reset', $row, null, true);
        } catch (\Exception $e) {
            //结束重置索引
            $index->stopRebuild();
            $this->error("发生错误：" . $e->getMessage());
        }

        //结束重置索引
        $index->endRebuild();
        //强制刷新索引
        $index->flushIndex();
        $this->success("重置索引数据库成功");

    }

    /**
     * 强制刷新
     */
    public function flush()
    {
        $project_id = $this->request->request('project_id');
        $row = $this->model->get($project_id);
        if (!$row) {
            $this->error("未找到指定项目");
        }
        //强制刷新索引
        Xunsearch::instance($row['name'])->getXS()->getIndex()->flushIndex();
        Xunsearch::instance($row['name'])->getXS()->getIndex()->flushLogging();
        $this->success("强制刷新索引数据库成功");
    }

    /**
     * 刷新配置
     */
    public function refresh()
    {
        $project_id = $this->request->request('project_id');
        $row = $this->model->get($project_id);
        if (!$row) {
            $this->error("未找到指定项目");
        }
        $fields = $row->fields()->where('status', 'normal')->select();
        $typeArr = [];
        foreach ($fields as $index => $field) {
            $typeArr[] = $field['type'];
        }
        $remainArr = array_diff(['id', 'title', 'body'], $typeArr);
        if ($remainArr) {
            $this->error("缺少的字段类型：" . implode(',', $remainArr));
        }
        $fieldList = [];
        foreach ($fields as $index => $field) {
            $item = [];
            $item[] = "[{$field['name']}]";
            if ($field['type'] != 'string') {
                $item[] = "type = {$field['type']}";
            }
            if ($field['index'] != 'none') {
                $item[] = "index = {$field['index']}";
            }
            if ($field['tokenizer'] != '') {
                $item[] = "tokenizer = {$field['tokenizer']}";
            }
            if ($field['cutlen'] != '' && $field['cutlen'] > 0) {
                $item[] = "cutlen = {$field['cutlen']}";
            }
            if ($field['weight'] != '' && $field['weight'] != 1) {
                $item[] = "weight = {$field['weight']}";
            }
            if ($field['phrase'] != 'no') {
                $item[] = "phrase = {$field['phrase']}";
            }
            if ($field['non_bool'] != 'no') {
                $item[] = "non_bool = {$field['non_bool']}";
            }
            $fieldList[] = implode("\n", $item);
        }
        $fieldData = implode("\n\n", $fieldList);
        $text = <<<EOD
project.name = {$row['name']}
project.default_charset = {$row['charset']}
server.index = {$row['serverindex']}
server.search = {$row['serversearch']}

{$fieldData}

EOD;
        $file = Xunsearch::getProjectIniFile($row['name']);
        try {
            $fp = fopen($file, "w+");
            fwrite($fp, $text);
        } catch (\Exception $e) {
            $this->error("生成配置失败,请检查目录读写权限");
        }

        try {
            $xs = new \XS($row['name']);
            $xs->setScheme(\XSFieldScheme::logger());
            $xs->index->setDb(\XSSearch::LOG_DB)->flushLogging();
            $xs->index->setDb(\XSSearch::LOG_DB)->flushIndex();
        } catch (\Exception $e) {
        }
        $this->success("生成配置成功");
    }

    /**
     * 检测元素是否可用
     * @internal
     */
    public function check_element_available()
    {
        $id = $this->request->request('id');
        $name = $this->request->request('name');
        $value = $this->request->request('value');
        $name = substr($name, 4, -1);
        if (!$name) {
            $this->error(__('Parameter %s can not be empty', 'name'));
        }
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
