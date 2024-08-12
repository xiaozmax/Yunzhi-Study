<?php

namespace addons\xunsearch;

use app\common\library\Menu;
use think\Addons;

/**
 * 插件
 */
class Xunsearch extends Addons
{

    /**
     * 插件安装方法
     * @return bool
     */
    public function install()
    {
        $menu = [
            [
                'name'    => 'xunsearch',
                'title'   => 'Xunsearch全文搜索管理',
                'icon'    => 'fa fa-search',
                'sublist' => [
                    [
                        'name'    => 'xunsearch/project',
                        'title'   => '项目管理',
                        'icon'    => 'fa fa-cog',
                        'sublist' => [
                            ['name' => 'xunsearch/project/index', 'title' => '查看'],
                            ['name' => 'xunsearch/project/add', 'title' => '添加'],
                            ['name' => 'xunsearch/project/edit', 'title' => '修改'],
                            ['name' => 'xunsearch/project/del', 'title' => '删除'],
                            ['name' => 'xunsearch/project/multi', 'title' => '批量更新'],
                            ['name' => 'xunsearch/project/reset', 'title' => '重置索引'],
                            ['name' => 'xunsearch/project/refresh', 'title' => '生成配置'],
                            ['name' => 'xunsearch/project/flush', 'title' => '强制刷新'],
                            ['name' => 'xunsearch/project/config', 'title' => '加载配置'],
                        ]
                    ],
                    [
                        'name'    => 'xunsearch/fields',
                        'title'   => '字段管理',
                        'icon'    => 'fa fa-list',
                        'ismenu'  => 0,
                        'remark'  => '管理项目索引的字段，如果增加了字段，请确保相应的整合接口有写入该字段数据',
                        'sublist' => [
                            ['name' => 'xunsearch/fields/index', 'title' => '查看'],
                            ['name' => 'xunsearch/fields/add', 'title' => '添加'],
                            ['name' => 'xunsearch/fields/edit', 'title' => '修改'],
                            ['name' => 'xunsearch/fields/del', 'title' => '删除'],
                            ['name' => 'xunsearch/fields/multi', 'title' => '批量更新'],
                        ]
                    ],
                    [
                        'name'    => 'xunsearch/logger',
                        'title'   => '搜索词管理',
                        'icon'    => 'fa fa-list',
                        'ismenu'  => 0,
                        'remark'  => '此列表结果由Xunsearch服务记录，提供如果搜索词没有相应的搜索结果，Xunsearch不会记录该记录值',
                        'sublist' => [
                            ['name' => 'xunsearch/logger/index', 'title' => '查看'],
                            ['name' => 'xunsearch/logger/add', 'title' => '添加'],
                            ['name' => 'xunsearch/logger/edit', 'title' => '修改'],
                            ['name' => 'xunsearch/logger/del', 'title' => '删除'],
                            ['name' => 'xunsearch/logger/multi', 'title' => '批量更新'],
                        ]
                    ]
                ]
            ]
        ];

        Menu::create($menu);
        return true;
    }

    /**
     * 插件卸载方法
     * @return bool
     */
    public function uninstall()
    {
        Menu::delete('xunsearch');
        return true;
    }

    /**
     * 插件启用方法
     * @return bool
     */
    public function enable()
    {
        Menu::enable('xunsearch');
        return true;
    }

    /**
     * 插件禁用方法
     * @return bool
     */
    public function disable()
    {
        Menu::disable('xunsearch');
        return true;
    }

    /**
     * 添加映射
     * @return mixed
     */
    public function appInit($param)
    {
        if (!defined('XS_APP_ROOT')) {
            define('XS_APP_ROOT', ADDON_PATH . 'xunsearch' . DS . 'data');
        }
        if (!class_exists("\XS") && !class_exists("\XSCommand")) {
            \addons\xunsearch\library\Xunsearch::addClassMap();
        }

        if (request()->isCli()) {
            \think\Console::addDefaultCommands([
                'addons\xunsearch\library\Client'
            ]);
        }
    }

}