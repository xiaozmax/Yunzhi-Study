<?php

namespace addons\prism;

use think\Addons;

/**
 * 插件
 */
class Prism extends Addons
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

    public function prismhook()
    {
        $config = $this->getConfig();

        $theme = isset($config['theme']) ? $config['theme'] : 'prism';
        $fontSize = isset($config['font_size']) ? $config['font_size'] : '14';
        $isAutoWrap = isset($config['auto_wrap']) ? $config['auto_wrap'] : '1';
        $isEnableLineNumber = isset($config['line_number']) ? $config['line_number'] : '0';

        $css = cdnurl("/assets/addons/prism/css/theme/{$theme}.css");
        $js = cdnurl('/assets/addons/prism/js/prism.js');

        $autoWrap = $lineNumberCss = $lineNumberJs = '';
        if ($isAutoWrap) {
            $autoWrap = 'white-space: pre-wrap;word-wrap: break-word;word-break: break-all;';
        }
        if ($isEnableLineNumber != '0') {
            $lineNumberCss = '<link rel="stylesheet" media="screen" href="' . cdnurl('/assets/addons/prism/css/plugin/prism-line-numbers.css') . '" />';


        }
        if ($isEnableLineNumber === '1') {
            $lineNumberJs = <<<'SCRIPT'
$(document).ready(function(){
    $("pre[class*='language-'],code[class*='language-']").addClass('line-numbers');
});
SCRIPT;
        }

        $output = <<<'SCRIPT'
<link rel="stylesheet" media="screen" href="%1$s" />
%2$s
<script type="text/javascript" src="%3$s"></script>
<style>
:not(pre) > code, pre {font-size: %4$spx; %5$s}
</style>
<script>
%6$s
</script>
SCRIPT;
        echo sprintf($output, $css, $lineNumberCss, $js, $fontSize, $autoWrap, $lineNumberJs);

    }

}
