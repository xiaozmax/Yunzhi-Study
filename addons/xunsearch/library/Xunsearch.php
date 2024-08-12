<?php

namespace addons\xunsearch\library;

use think\Log;

class Xunsearch
{
    protected static $instance = [];
    public $project;

    private $_xs;
    private $_scws;

    public function __construct($project)
    {
        $this->project = $project;
        $this->_xs = new \XS($this->project);
    }

    /**
     * 获取Xunsearch单例
     *
     * @param string $project 项目名称
     * @return Xunsearch
     */
    public static function instance($project)
    {
        if (!isset(self::$instance[$project])) {
            self::$instance[$project] = new static($project);
        }

        return self::$instance[$project];
    }

    /**
     * 获取XS对象
     *
     * @return \XS
     */
    public function getXS()
    {
        return $this->_xs;
    }

    /**
     * 添加别名映射
     */
    public static function addClassMap()
    {
        $xsLibDir = __DIR__ . DS . 'xunsearch';
        $maps = [
            'XS'               => $xsLibDir . '/lib/XS.class.php',
            'XSCommand'        => $xsLibDir . '/lib/XSServer.class.php',
            'XSComponent'      => $xsLibDir . '/lib/XS.class.php',
            'XSDocument'       => $xsLibDir . '/lib/XSDocument.class.php',
            'XSErrorException' => $xsLibDir . '/lib/XS.class.php',
            'XSException'      => $xsLibDir . '/lib/XS.class.php',
            'XSFieldMeta'      => $xsLibDir . '/lib/XSFieldScheme.class.php',
            'XSFieldScheme'    => $xsLibDir . '/lib/XSFieldScheme.class.php',
            'XSIndex'          => $xsLibDir . '/lib/XSIndex.class.php',
            'XSSearch'         => $xsLibDir . '/lib/XSSearch.class.php',
            'XSServer'         => $xsLibDir . '/lib/XSServer.class.php',
            'XSTokenizer'      => $xsLibDir . '/lib/XSTokenizer.class.php',
            'XSTokenizerFull'  => $xsLibDir . '/lib/XSTokenizer.class.php',
            'XSTokenizerNone'  => $xsLibDir . '/lib/XSTokenizer.class.php',
            'XSTokenizerScws'  => $xsLibDir . '/lib/XSTokenizer.class.php',
            'XSTokenizerSplit' => $xsLibDir . '/lib/XSTokenizer.class.php',
            'XSTokenizerXlen'  => $xsLibDir . '/lib/XSTokenizer.class.php',
            'XSTokenizerXstep' => $xsLibDir . '/lib/XSTokenizer.class.php',
        ];
        if (class_exists("\\think\\Loader")) {
            \think\Loader::addClassMap($maps);
        } else {
            spl_autoload_register(function ($className) use ($maps) {
                if (isset($maps[$className])) {
                    require($maps[$className]);
                }
            });
        }
    }

    /**
     * 获取项目配置文件
     *
     * @param string $project 项目名称
     * @return string
     */
    public static function getProjectIniFile($project)
    {
        return ADDON_PATH . 'xunsearch' . DS . 'data' . DS . $project . '.ini';
    }

    /**
     * 添加数据
     *
     * @param mixed $data XSDocument对象或数组，必须包含主键
     */
    public function add($data)
    {
        $this->update($data, true);
    }

    /**
     * 更新数据
     *
     * @param mixed   $data XSDocument对象或数组，必须包含主键
     * @param boolean $add  是否为新增
     */
    public function update($data, $add = false)
    {
        try {
            if ($data instanceof \XSDocument) {
                $this->_xs->index->update($data, $add);
            } else {
                $doc = new \XSDocument($data);
                $this->_xs->index->update($doc, $add);
            }
        } catch (\XSException $e) {
            Log::record($e->getMessage());
        }
    }

    /**
     * 删除数据
     *
     * @param mixed $pid 主键信息
     */
    public function del($pid)
    {
        try {
            $this->_xs->index->del($pid);
        } catch (\XSException $e) {
            Log::record($e->getMessage());
        }
    }

    /**
     * 获取分词
     * @return \XSTokenizerScws
     */
    public function getScws()
    {
        if ($this->_scws === null) {
            $this->_scws = new \XSTokenizerScws;
        }
        return $this->_scws;
    }

    /**
     * 获取建议列表
     * @param string  $query 搜索词
     * @param integer $limit 需要返回的搜索词数量上限
     * @return array
     */
    public function suggestion($query, $limit = 10)
    {
        $result = [];
        if (!empty($query)) {
            try {
                $result = $this->_xs->search->getExpandedQuery($query, $limit);
            } catch (\XSException $e) {
                //
            }
        }
        return $result;
    }

    /**
     * 获取相关搜索列表
     * @param string  $query 搜索词
     * @param integer $limit 需要返回的搜索词数量上限
     * @return array
     */
    public function related($query, $limit = 10)
    {
        $result = [];
        if (!empty($query)) {
            try {
                $result = $this->_xs->search->getRelatedQuery($query, $limit);
            } catch (\XSException $e) {
                //
            }
        }
        return $result;
    }

    /**
     * 获取搜索结果
     * @param string  $query    搜索词
     * @param integer $page     分页页码
     * @param integer $pagesize 分页大小
     * @param string  $order    排序
     * @param bool    $fulltext 是否全文搜索
     * @param bool    $fuzzy    是否模糊搜索
     * @param bool    $synonyms 是否同义词
     * @return array
     */
    public function search($query, $page = 1, $pagesize = 20, $order = '', $fulltext = true, $fuzzy = false, $synonyms = false)
    {
        $pager = '';
        $count = 0;
        $total = 0;
        $searchCost = 0;
        $list = [];
        $corrected = [];
        $related = [];
        $highlight = function ($content) {
            return $content;
        };
        // 全文搜索
        try {
            $search = $this->_xs->search;
            $search->setCharset('UTF-8');

            // 设定模糊搜索
            $search->setFuzzy((bool)$fuzzy);

            // 设置同义词
            $search->setAutoSynonyms((bool)$synonyms);

            if (($field = $this->_xs->getFieldTitle()) !== false) {
                $fieldTitle = $field->name;
            }

            // 设置全文搜索
            if ($fulltext) {
                $search->setQuery($query);
            } else {
                $search->setQuery("{$fieldTitle}:({$query})");
            }

            //搜索大小
            $search->setLimit($pagesize, ($page - 1) * $pagesize);

            $order = str_replace(' ', '_', $order);
            // 设置排序
            if (($pos = strrpos($order, '_')) !== false) {
                $sf = substr($order, 0, $pos);
                $st = substr($order, $pos + 1);
                $search->setSort($sf, strtoupper($st) === 'ASC');
            }

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
                $baseUrl = request()->url(true);
                $baseUrl = preg_match("/([\?|&])page=([0-9]+)/", $baseUrl) ? $baseUrl :
                    $baseUrl . (stripos($baseUrl, '?') === false ? "?" : "&") . "page=1";
                do {
                    $pageUrl = preg_replace("/([\?|&])page=([0-9]+)/", "$1page={$pb}", $baseUrl);
                    $pager .= ($pb == $page) ? '<li data-page="' . $page . '" class="active"><span>' . $page . '</span></li>' : '<li data-page="' . $pb . '"><a href="' . $pageUrl . '">' . $pb . '</a></li>';
                } while (++$pb < $pe);
            }

            foreach ($docs as $index => $doc) {
                $data = $doc->getFields();
                $list[] = $data;
            }
            $highlight = function ($content) use ($search) {
                return $search->highlight($content);
            };
        } catch (\XSException $e) {
            Log::record($e->getMessage());
        }
        return [
            'count'        => $count,
            'total'        => $total,
            'list'         => $list,
            'page'         => $page,
            'pagesize'     => $pagesize,
            'corrected'    => $corrected,
            'related'      => $related,
            'pager'        => $pager,
            'highlight'    => $highlight,
            'microseconds' => $searchCost,
        ];
    }

}
