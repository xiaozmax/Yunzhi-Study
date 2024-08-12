<?php

namespace addons\clicaptcha\controller;

use addons\clicaptcha\library\Clicaptcha;
use think\addons\Controller;

class Index extends Controller
{

    public function index()
    {
        $this->error("当前插件暂无前台页面");
    }

    /**
     * 初始化验证码
     */
    public function start()
    {
        $clicaptcha = new Clicaptcha();
        $do = $this->request->post('do');
        if ($do == 'check') {
            echo $clicaptcha->check($this->request->post("info"), false) ? 1 : 0;
            return;
        } else {
            $config = get_addon_config('clicaptcha');
            return $clicaptcha->create();
        }
    }
}
