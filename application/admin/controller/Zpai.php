<?php

namespace app\admin\controller;

use Firebase\JWT\JWT;
use think\Controller;

class Zpai extends Controller
{
    private function generate_token($apikey, $exp_seconds)
    {
        try {
            list($id, $secret) = explode('.', $apikey, 2);
        } catch (Exception $e) {
            throw new Exception('invalid apikey', 0, $e);
        }
        $payload = [
            'api_key' => $id,
            'exp' => round(microtime(true) * 1000) + $exp_seconds * 1000,
            'timestamp' => round(microtime(true) * 1000),
        ];

        return JWT::encode($payload, $secret, 'HS256', null, ['sign_type' => 'SIGN']);
    }

    private function request_by_curl($remote_server, $post_string)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $remote_server);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, "jb51.net's CURL Example beta");

        // 设置 HTTP 头部
        $headers = [
            'Content-Type: application/json',
            'Content-Length: '.strlen($post_string),
            'Authorization: '.self::generate_token('token', 7200),
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

    private function test()
    {
        $post_string = json_encode([
            'model' => 'glm-4',
            'messages' => [
                ['role' => 'user', 'content' => $_GET['askai']],
            ],
        ]);
        $returndata = self::request_by_curl('https://open.bigmodel.cn/api/paas/v4/chat/completions', $post_string);
        /*$postdata = array(
            'model' => 'glm-4',
            'messages' => '{"role": "user", "content": "你好"}'
          );
        $returndata = self::send_post('https://open.bigmodel.cn/api/paas/v4/chat/completions', $postdata);
        echo 'started';*/
        //$this->testdo();
        return $returndata;
    }

    private function index()
    {
        return self::generate_token('token', 7200);
    }

    private function testdo()
    {
        if (!extension_loaded('pcntl')) {
            die('This script requires the PCNTL extension.');
        }
        // 设置脚本运行时间无限制
        set_time_limit(0);
        // 创建管道
        $pid = pcntl_fork();
        if ($pid == -1) {
            die('Could not fork');
        } elseif ($pid) {
            // 父进程
            echo "Forked a child process with PID $pid\n";
            // 打开管道文件描述符
            $pipe = pcntl_open_pipe();
            if ($pipe === false) {
                die('Could not open pipe');
            }
            // 等待子进程结束
            pcntl_waitpid($pid, $status);
            // 检查子进程是否正常结束
            if ($status != 0) {
                echo "Child exited with status $status\n";
            }
            // 从管道读取输出
            while ($output = pcntl_read_pipe($pipe)) {
                echo 'Output from child process: '.$output."\n";
                // 你可以在这里将输出写入文件
            }
            // 关闭管道
            pcntl_close_pipe($pipe);
        } else {
            // 子进程
            // 执行命令，这里使用shell_exec，需要注意安全问题
            $command = 'ping -c 30 -i 1 10.0.0.1';
            $output = shell_exec($command);
            // 将输出写入管道
            pcntl_write_pipe($pipe, $output);
            // 确保子进程结束时清理资源
            exit(0);
        }
    }
}
