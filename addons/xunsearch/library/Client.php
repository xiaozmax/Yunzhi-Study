<?php

namespace addons\xunsearch\library;

ini_set('display_errors', 'on');

use addons\xunsearch\model\Project;
use think\Cache;
use think\Config;
use think\console\Command;
use think\console\Input;
use think\console\input\Option;
use think\console\Output;
use think\Exception;

/**
 * Xunsearch客户端管理服务
 */
class Client extends Command
{

    protected function configure()
    {
        $this->setName('xunsearch')
            ->addOption('url', 'u', Option::VALUE_OPTIONAL, 'website url', '')
            ->addOption('project', 'p', Option::VALUE_REQUIRED, "project name")
            ->addOption('action', 'a', Option::VALUE_REQUIRED, "action:reset|flush|clean")
            ->addOption('force', 'f', Option::VALUE_OPTIONAL, 'force override general file', false)
            ->setDescription('Xunsearch Manager');
    }

    protected function execute(Input $input, Output $output)
    {
        $name = trim($input->getOption('project') ?: '');
        $action = trim($input->getOption('action') ?: '');
        $project = Project::getByName($name);
        if (!$project || $project['status'] != 'normal') {
            throw new Exception("未找到指定的项目");
        }

        if (!in_array($action, ['reset', 'flush', 'config', 'clean'])) {
            throw new Exception("未找到指定的方法:[{$action}]");
        }

        call_user_func_array([$this, $action], [$input, $output, $project]);

    }

    /**
     * 重置索引
     */
    protected function reset($input, $output, $project)
    {
        $url = $input->getOption('url');
        if (!$url) {
            throw new Exception("缺少参数网站URL");
        }
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new Exception("网站URL不是一个正确的URL地址");
        }
        $arr = parse_url($url);
        $server = [
            'SERVER_PORT'     => $arr['port'] ?? ($arr['scheme'] == 'https' ? 443 : 80),
            'REQUEST_SCHEME'  => $arr['scheme'],
            'SERVER_PROTOCOL' => $arr['scheme'] . '://',
            'HTTP_HOST'       => $arr['host'],
            'SERVER_NAME'     => $arr['host'],
            'argv'            => ['', ($arr['path'] ?? '') . (isset($arr['query']) ? "?" . $arr['query'] : '')]
        ];
        $_SERVER = array_merge($_SERVER, $server);
        \think\Config::set("app_host", $arr['host']);

        $hooks = Cache::get('hooks', []);
        $resetHooks = $hooks['xunsearch_index_reset'] ?? [];
        $className = '\\addons\\' . $project['name'] . '\\' . ucfirst($project['name']);
        if (!in_array($className, $resetHooks)) {
            throw new Exception("未找到项目的重置接口，无法重置");
        }

        //将后缀设置为HTML，避免新生成的URL不带HTML
        Config::set('url_html_suffix', 'html');

        set_time_limit(0);
        $index = Xunsearch::instance($project['name'])->getXS()->getIndex();
        //关闭之前的索引，避免中途有关闭的情况
        $index->stopRebuild();
        //清空索引
        //$index->clean();
        //开始重置索引
        $index->beginRebuild();

        try {
            $result = \think\Hook::listen('xunsearch_index_reset', $project, null, true);
        } catch (\Exception $e) {
            //结束重置索引
            $index->stopRebuild();
            $output->warning("发生错误：" . $e->getMessage());
        }

        //结束重置索引
        $index->endRebuild();
        //强制刷新索引
        $index->flushIndex();
        $output->info("重置索引数据库成功");
    }

    /**
     * 刷新索引缓存
     */
    protected function flush($input, $output, $project)
    {
        Xunsearch::instance($project['name'])->getXS()->getIndex()->flushIndex();
        $output->info("刷新缓存成功");
    }

    /**
     * 清空索引数据库
     */
    protected function clean($input, $output, $project)
    {
        $force = $input->getOption('force');
        if (!$force) {
            throw new Exception("If you need to clean index, use the parameter --force=true ");
        }
        Xunsearch::instance($project['name'])->getXS()->getIndex()->stopRebuild();
        Xunsearch::instance($project['name'])->getXS()->getIndex()->clean();
        $output->info("清空索引数据库成功");
    }

}
