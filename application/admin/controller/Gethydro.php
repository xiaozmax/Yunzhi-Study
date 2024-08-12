<?php

namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Request;

class Gethydro extends Controller
{
    public function inhydro()
    {
        return $this->fetch();
        return "developing";
    }
    public function index()
    {
        $systemtype=php_uname();
        $sysunsuport=0;
        if(strpos($systemtype,"CentOS")){
            $sysunsuport=1;
        }if(strpos($systemtype,"Alibaba Cloud Linux")){
            $sysunsuport=1;
        }if(strpos($systemtype,"TencentOS")){
            $sysunsuport=1;
        }if(strpos($systemtype,"OpenCloudOS")){
            $sysunsuport=1;
        }
        if($sysunsuport==1){
            return "<center><h1>This system is not suported.</h1>";
        }
        $shell = "pm2 ls";
        $output = shell_exec($shell);
        if(strpos($output,"hydrooj"))
        {
            echo "<center><h1>Hydro oj已被安装，无需重复安装</h1>";
            return ;
        }
        return $this->fetch();
        return "<center><h1><a href='gethydro/inhydro'><button onclick=''>点击前往安装页面</button></a></h1>";
    }

    public function test()
    {
        echo 'started';
        $this->testdo();
        return "1";
    }

    public function testdo()
    {
        if (!extension_loaded('pcntl')) {
            die("This script requires the PCNTL extension.");
        }
        // 设置脚本运行时间无限制
        set_time_limit(0);
        // 创建管道
        $pid = pcntl_fork();
        if ($pid == -1) {
            die("Could not fork");
        } elseif ($pid) {
            // 父进程
            echo "Forked a child process with PID $pid\n";
            // 打开管道文件描述符
            $pipe = pcntl_open_pipe();
            if ($pipe === false) {
                die("Could not open pipe");
            }
            // 等待子进程结束
            pcntl_waitpid($pid, $status);
            // 检查子进程是否正常结束
            if ($status != 0) {
                echo "Child exited with status $status\n";
            }
            // 从管道读取输出
            while ($output = pcntl_read_pipe($pipe)) {
                echo "Output from child process: " . $output . "\n";
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
