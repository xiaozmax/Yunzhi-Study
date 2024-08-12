<?php

namespace addons\loginbgindex;

use think\Addons;
use think\Request;

/**
 * 登录背景图插件
 */
class Loginbgindex extends Addons
{

    /**
     * 插件安装方法
     * @return bool
     */
    public function install()
    {
        return true;
    }

    /**
     * 插件卸载方法
     * @return bool
     */
    public function uninstall()
    {
        return true;
    }

    public function responseSend()
    {
        $request = Request::instance();

        if ($request->path() == "index/user/login" && !$request->isAjax() && !$request->isPost()) {
            $config = $this->getConfig();
            if ($config['mode'] == 'random' || $config['mode'] == 'daily') {
                $index = $config['mode'] == 'random' ? mt_rand(1, 4000) : date("Ymd") % 4000;
                $background = "http://img.infinitynewtab.com/wallpaper/" . $index . ".jpg";
            } else {
                $background = cdnurl($config['image']);
            }

            echo '<style type="text/css">
            body {
                color:#999;
                background:url(' . $background . ');
                background-size:cover;
            }
        </style>';
        }
    }

    public function indexLoginInit(\think\Request &$request)
    {
        $config = $this->getConfig();
        if ($config['mode'] == 'random' || $config['mode'] == 'daily') {
            $index = $config['mode'] == 'random' ? mt_rand(1, 4000) : date("Ymd") % 4000;
            $background = "http://img.infinitynewtab.com/wallpaper/" . $index . ".jpg";
        } else {
            $background = cdnurl($config['image']);
        }
        \think\View::instance()->assign('background', $background);
    }
}
