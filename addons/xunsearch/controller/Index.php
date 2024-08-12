<?php

namespace addons\xunsearch\controller;

use addons\xunsearch\library\Xunsearch;
use addons\xunsearch\model\Project;
use think\addons\Controller;

class Index extends Controller
{
    protected $layout = 'default';

    public function index()
    {
        $config = get_addon_config('xunsearch');
        if (!$config['defaultproject']) {
            $this->error("请在后台插件管理中配置默认搜索项目");
        }
        return $this->search();
    }

    /**
     * 搜索页
     */
    public function search()
    {
        $config = get_addon_config('xunsearch');
        $name = $this->request->param('name', $config['defaultproject']);
        if (!$name) {
            $this->error("未找到请求的项目");
        }
        $project = Project::getByName($name);
        if (!$project || $project['status'] != 'normal' || !$project['isfrontend']) {
            $this->error("未找到请求的项目");
        }

        $q = trim($this->request->get('q', ''));
        $page = $this->request->get('page/d', '1');
        $order = $this->request->get('order', '');
        $fulltext = $this->request->get('fulltext/d', '1');
        $fuzzy = $this->request->get('fuzzy/d', '0');
        $synonyms = $this->request->get('synonyms/d', '0');
        $hot = [];
        try {
            $hot = Xunsearch::instance($project['name'])->getXS()->getSearch()->getHotQuery();
        } catch (\XSException $e) {
            $this->error("发生错误，请检查是否生成项目配置");
        }
        if (!$q) {
            $template = $project['indextpl'] ? $project['indextpl'] : 'index';
            return $this->view->fetch("/search/{$template}", ['title' => $project['title'], 'project' => $project, 'hot' => $hot]);
        }
        $orderList = [
            'relevance' => '默认排序',
        ];

        // 相对链接
        $baseUrl = '?q=' . urlencode($q) . '&fuzzy=' . $fuzzy . '&fulltext=' . $fulltext . '&synonyms=' . $synonyms . '&order=' . $order;

        // 变量定义
        $count = $total = $searchCost = 0;
        $docs = $related = $corrected = [];
        $error = $pager = '';
        $totalBegin = microtime(true);
        $search = null;

        $fieldColumn = [];
        $fieldList = $project->fields()->where('status', 'normal')->column('name,title,extra,sortable');
        foreach ($fieldList as $index => $item) {
            $fieldColumn[$item['name']] = $item['title'];
        }
        $filterList = '';
        $fieldId = 'id';
        $fieldTitle = 'title';
        $fieldBody = 'body';
        $extraFieldList = [];

        // 全文搜索
        try {
            $xs = new \XS($project['name']);
            $search = $xs->search;

            $fieldId = $xs->getFieldId()->name;
            if (($field = $xs->getFieldTitle()) !== false) {
                $fieldTitle = $field->name;
            }
            if (($field = $xs->getFieldBody()) !== false) {
                $fieldBody = $field->name;
            }
            foreach ($xs->getAllFields() as $field) {
                if ($field->hasIndexSelf() && $field->type != \XSFieldMeta::TYPE_BODY && !$field->isBoolIndex()) {
                    $filterList .= sprintf('<label class="radio inline"><input type="radio" name="f" value="%s" %s />%s</label>', $field->name, $field->name, isset($fieldColumn[$field->name]) ? $fieldColumn[$field->name] : $field->name);
                }
                if ($field->isNumeric() && isset($fieldList[$field->name]) && $fieldList[$field->name]['sortable']) {
                    $orderList[$field->name . '_desc'] = ($fieldColumn[$field->name] ?? $field->name) . "从大到小";
                    $orderList[$field->name . '_asc'] = ($fieldColumn[$field->name] ?? $field->name) . "从小到大";
                }
                if ($field->isSpeical()) {
                    continue;
                }
                if ($field->type == \XSFieldMeta::TYPE_STRING) {
                    if (!isset($fieldTitle)) {
                        $fieldTitle = $field->name;
                        continue;
                    }
                    if (!isset($fieldBody)) {
                        $fieldBody = $field->name;
                        continue;
                    }
                }
                if (isset($fieldList[$field->name]) && $fieldList[$field->name]['extra']) {
                    $extraFieldList[] = $field;
                }
            }
            $filterList = trim($filterList);
            if (!isset($fieldTitle)) {
                $fieldTitle = 'title';
            }
            if (!isset($fieldBody)) {
                $fieldBody = 'body';
            }

            if ($project['isfuzzy']) {
                // 设定模糊搜索
                $search->setFuzzy((bool)$fuzzy);
            }
            if ($project['issynonyms']) {
                // 设置同义词
                $search->setAutoSynonyms((bool)$synonyms);
            }

            // 设置全文搜索
            if ($fulltext) {
                $search->setQuery($q);
            } else {
                $search->setQuery("{$fieldTitle}:({$q})");
            }

            // 设置排序
            if (($pos = strrpos($order, '_')) !== false) {
                $sf = substr($order, 0, $pos);
                $st = substr($order, $pos + 1);
                $search->setSort($sf, strtoupper($st) === 'ASC');
            }

            // 设置分页
            $page = max(1, intval($page));
            $pagesize = $project['pagesize'] ? $project['pagesize'] : \XSSearch::PAGE_SIZE;
            $search->setLimit($pagesize, ($page - 1) * $pagesize);

            // 获取搜索耗时
            $searchBegin = microtime(true);
            $docs = $search->search();
            $searchCost = microtime(true) - $searchBegin;

            // 获取搜索记录数和总记录数
            $count = $search->getLastCount();
            $total = $search->getDbTotal();

            // 判断是否有搜索结果
            if ($count < 1 || $count < ceil(0.001 * $total)) {
                $corrected = $search->getCorrectedQuery();
            }
            // 获取相关搜索
            $related = $search->getRelatedQuery();

            // 生成分页
            if ($count > $pagesize) {
                $pb = max($page - 5, 1);
                $pe = min($pb + 10, ceil($count / $pagesize) + 1);
                $pager = '';
                do {
                    $pager .= ($pb == $page) ? '<li class="active"><span>' . $page . '</span></li>' : '<li><a href="' . $baseUrl . '&page=' . $pb . '">' . $pb . '</a></li>';
                } while (++$pb < $pe);
            }
        } catch (\XSException $e) {
            $error = strval($e);
        }
        // 计算总耗时
        $totalCost = microtime(true) - $totalBegin;
        $data = [
            'q'              => $q,
            'error'          => $error,
            'total'          => $total,
            'count'          => $count,
            'docs'           => $docs,
            'pager'          => $pager,
            'hot'            => $hot,
            'related'        => $related,
            'searchCost'     => $searchCost,
            'totalCost'      => $totalCost,
            'corrected'      => $corrected,
            'search'         => $search,
            'fulltext'       => $fulltext,
            'synonyms'       => $synonyms,
            'fuzzy'          => $fuzzy,
            'order'          => $order,
            'orderList'      => $orderList,
            'project'        => $project,
            'fieldColumn'    => $fieldColumn,
            'fieldId'        => $fieldId,
            'fieldTitle'     => $fieldTitle,
            'fieldBody'      => $fieldBody,
            'filterList'     => $filterList,
            'extraFieldList' => $extraFieldList,
        ];

        $template = $project['listtpl'] ?: "list";
        $this->view->assign("title", "搜索结果 - {$project['title']}");
        $this->view->assign($data);
        return $this->view->fetch("/search/{$template}");
    }

    /**
     * 搜索建议列表
     */
    public function suggestion()
    {
        $name = $this->request->request('name', '');
        $q = $this->request->request('q', '');
        if (!$name) {
            $this->error("未找到请求的项目");
        }
        $project = Project::getByName($name);
        if (!$project || $project['status'] != 'normal') {
            $this->error("未找到请求的项目");
        }

        $terms = Xunsearch::instance($project['name'])->suggestion($q);
        return json($terms);
    }
}
