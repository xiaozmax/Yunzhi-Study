<?php

namespace addons\clicaptcha;

use think\Addons;
use think\Validate;

/**
 * 全新点选验证码插件
 */
class Clicaptcha extends Addons
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
     * 自定义captcha验证事件
     */
    public function actionBegin()
    {
        $module = strtolower(request()->module());
        if (in_array($module, ['index', 'admin', 'api', 'store'])) {
            Validate::extend('captcha', function ($value, $id = "") {
                $clicaptcha = new \addons\clicaptcha\library\Clicaptcha();
                $value = $value ? $value : request()->post("captcha");
                if (!$clicaptcha->check($value, true)) {
                    return false;
                };
                return true;
            });
        }
    }

    /**
     * 脚本替换
     */
    public function viewFilter(&$content)
    {
        $module = strtolower(request()->module());
        if (($module == 'index' && config('fastadmin.user_register_captcha') == 'text') || ($module == 'admin' && config('fastadmin.login_captcha')) || ($module == 'store' && config('fastadmin.login_captcha'))) {
            $content = preg_replace_callback('/<!--@CaptchaBegin-->([\s\S]*?)<!--@CaptchaEnd-->/i', function ($matches) {
                return '<!--@CaptchaBegin--><div><input type="hidden" name="captcha" /></div><!--@CaptchaEnd-->';
            }, $content);
        }
    }

    public function captchaMode()
    {
        return 'clicaptcha';
    }

}
