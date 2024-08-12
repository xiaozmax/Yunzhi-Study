<?php

namespace addons\clicaptcha\controller;

use addons\clicaptcha\library\Clicaptcha;
use think\Config;

/**
 * 公共
 */
class Api extends \app\common\controller\Api
{
    protected $noNeedLogin = '*';

    public function _initialize()
    {

        if (isset($_SERVER['HTTP_ORIGIN'])) {
            header('Access-Control-Expose-Headers: __token__');//跨域让客户端获取到
            header('Access-Control-Expose-Headers: X-Clicaptcha-Text');//跨域让客户端获取到
        }
        //跨域检测
        check_cors_request();

        if (!isset($_COOKIE['PHPSESSID'])) {
            Config::set('session.id', $this->request->server("HTTP_SID"));
        }
        parent::_initialize();
    }

    public function index()
    {
        $this->error("当前插件暂无前台页面");
    }

    /**
     * 获取验证码
     */
    public function start()
    {
        $clicaptcha = new Clicaptcha();
        $response = $clicaptcha->create();
        $contentType = $response->getHeader('Content-Type');
        $text = urldecode($response->getHeader('X-Clicaptcha-Text'));
        $content = $response->getContent();
        $this->success($text, 'data:' . $contentType . ';base64,' . base64_encode($content));
    }

    /**
     * 判断验证码
     */
    public function check()
    {
        $clicaptcha = new Clicaptcha();
        $result = $clicaptcha->check($this->request->post("info", $this->request->post("captcha")), false);
        if ($result) {
            $this->success();
        } else {
            $this->error();
        }
    }
}
