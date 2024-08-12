<?php

namespace addons\darktheme;

use app\common\library\Menu;
use think\Addons;
use think\Config;
use think\Hook;
use think\Request;

/**
 * 深色模式插件
 */
class Darktheme extends Addons
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

    /**
     * 插件启用方法
     * @return bool
     */
    public function enable()
    {

        return true;
    }

    /**
     * 插件禁用方法
     * @return bool
     */
    public function disable()
    {

        return true;
    }

    /**
     * HTML替换
     */
    public function viewFilter(&$content)
    {
        $config = $this->getConfig();
        $info = get_addon_info('darktheme');
        $request = Request::instance();
        $module = strtolower($request->module());
        $controller = strtolower($request->controller());
        $action = strtolower($request->action());
        if ($module != 'admin') {
            return;
        }

        //判断忽略的URL
        $url = $request->url();
        $url = preg_replace("/\/(\w+)\.php\//i", '/', $url);
        $ignoreUrlArr = array_filter(explode("\n", str_replace(["\r\n"], "\n", $config['ignoreurllist'])));
        foreach ($ignoreUrlArr as $index => $item) {
            if (stripos($url, $item) === 0) {
                return;
            }
        }


        //判断用户是否有手动设定样式
        $mode = $config['mode'];
        $thememode = cookie("thememode");
        if ($thememode && in_array($thememode, ['dark', 'light'])) {
            $mode = $thememode;
            $config['mode'] = $thememode;
        }

        $mode = $mode === 'force' ? 'dark' : $mode;

        //计算资源路径
        $cdnurl = Config::get('view_replace_str.__CDN__');
        if ($mode === 'dark' || $mode === 'force') {
            $content = preg_replace("/<body(.*?)class=\"(.*?)\"/i", "<body\$1class=\"\$2 darktheme\"", $content);
            $content = preg_replace("/<body>/i", "<body class='darktheme'>", $content);
        } elseif (!$thememode) {
            $content = preg_replace("/<body(.*?)>/i", "<body\$1><script>window.matchMedia('(prefers-color-scheme: dark)').matches&&document.body.classList.add(\"darktheme\");</script>", $content);
        }

        //模式判断
        $media = $config['mode'] == 'auto' ? 'media="(prefers-color-scheme: dark)"' : '';
        $media = '';
        $cssfile = '<link href="' . $cdnurl . '/assets/addons/darktheme/css/darktheme.css?v=' . ($info['version'] ?? '1.0.0') . '" rel="stylesheet" ' . $media . ' data-mode="' . $mode . '" class="darktheme-link">';
        $customcss = $config['customcss'] ?? '';

        //替换页面中的自定深色CSS文件
        $content = preg_replace_callback("/<link(.*?)data\-render=\"darktheme\"(.*?)>/i", function ($match) use ($media) {
            $match[0] = str_replace('<link', '<link ' . $media, $match[0]);
            return $match[0];
        }, $content);

        //替换页面中的自定义深色样式
        $content = preg_replace_callback("/<style\sdata\-render=\"darktheme\">([\s\S]*?)<\/style>/i", function ($match) use (&$customcss) {
            $customcss = $customcss . "\n" . $match[1];
            return '';
        }, $content);

        //添加自定义CSSHook，便于其它插件适配
        $results = Hook::listen("darktheme_customcss", $content);
        foreach ($results as $index => $result) {
            if (!$result) {
                continue;
            }
            $result = str_replace('__CDN__', $cdnurl, $result);
            if (stripos($result, 'body.darktheme') !== false || stripos($result, '{') !== false) {
                $customcss = $customcss . "\n" . $result;
            } else {
                $cssfile = $cssfile . "\n" . '<link href="' . $result . '" rel="stylesheet" ' . $media . ' class="darktheme-link">';
            }
        }
        $cssfile = $cssfile . '<link href="/assets/addons/darktheme/css/switch.css?v=' . ($info['version'] ?? '1.0.0') . '" rel="stylesheet" >';

        //自定义CSS
        if ($customcss) {
            $cssmediabegin = $config['mode'] == 'auto' ? "@media (prefers-color-scheme: dark) {\n" : "";
            $cssmediaend = $config['mode'] == 'auto' ? "\n}" : "";
            $cssmediabegin = $cssmediaend = "";
            $cssfile .= "\n<style>\n{$cssmediabegin}{$customcss}{$cssmediaend}\n</style>";
        }

        //在head前写入CSS
        $content = preg_replace("/<\/head>/i", $cssfile . "\n\$0", $content);
    }

    /**
     * @param $params
     */
    public function configInit(&$params)
    {
        $config = $this->getConfig();
        $mode = $config['mode'];
        $thememode = cookie("thememode");
        if ($thememode && in_array($thememode, ['dark', 'light'])) {
            $mode = $thememode;
        }

        $mode = $mode === 'force' ? 'dark' : $mode;

        $params['darktheme'] = [
            'switchbtn' => !!$config['switchbtn'],
            'mode'      => $mode
        ];
    }

}
