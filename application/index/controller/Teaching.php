<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use Firebase\JWT\JWT;
use think\Db;

/**
 * 会员中心.
 */
class Teaching extends Frontend
{
    protected $layout = 'default';
    protected $noNeedLogin = [];
    protected $noNeedRight = ['*'];

    private function checksignin($signin_id, $user_id)
    {
        $result = Db::table('fa_signin_record')->where([
            'signinid' => $signin_id,
            'userid' => $user_id,
        ])->find();
        // 判断查询结果是否存在
        if ($result) {
            // 如果存在，返回真
            return true;
        } else {
            // 如果不存在，返回假
            return false;
        }
    }

    public function index()
    {
        return ' <meta http-equiv="refresh" content="0;url=/index/user ">';
    }

    public function signinlist()
    {
        $title = '签到中心';
        $this->assign('title', $title);

        return $this->view->fetch();
    }

    public function signinnow()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $title = '签到中心';
            $this->assign('title', $title);
            if (!isset($_GET['signin_id'])) {
                return 'err';
            }
            $auth = \app\common\library\Auth::instance();
            $user = $auth->getUser();
            $user_id = $user['id'];
            $signin_id = $_GET['signin_id'];
            $group_id = Db::table('fa_signin')->where('sign_id', $signin_id)->field('userrange')->find();
            if ($group_id) {
                // 获取 classid 的值
                $group_id = $group_id['userrange'];
            }
            $user_group_id = Db::table('fa_user')->where('id', $user_id)->field('group_id')->find();
            if ($user_group_id) {
                // 获取 classid 的值
                $user_group_id = $user_group_id['group_id'];
            }
            if ($user_group_id != $group_id) {
                return $this->view->fetch('signinnow', ['can_signin' => 0, 'signin_name' => '0', 'start_time' => '0', 'end_time' => '0', 'signin_type' => '0', 'user_type' => 'err']);
            }
            $signin_data = Db::table('fa_signin')
            ->where('sign_id', $signin_id)
            ->find();
            $start_time = date('Y-m-d H:i:s', $signin_data['starttime']);
            $end_time = date('Y-m-d H:i:s', $signin_data['endtime']);
            $nowtime = time();
            $signin_type = 'on'; //进行中
            if ($nowtime > $signin_data['endtime']) {
                $signin_type = 'ended'; //结束
            }
            if ($nowtime < $signin_data['starttime']) {
                $signin_type = 'waiting'; //未开始
            }
            $user_type = 0; //未签到
            if (self::checksignin($signin_id, $user_id)) {
                $user_type = 1; //已签到
            }

            return $this->view->fetch('signinnow', ['can_signin' => 1, 'signin_name' => $signin_data['name'], 'start_time' => $start_time, 'end_time' => $end_time, 'signin_type' => $signin_type, 'user_type' => $user_type]);
        }//以上为GET部分，展示给用户看的：）
        //下面就是POST获取数据的地方了，用来鉴权
        $auth = \app\common\library\Auth::instance(); //Fastadmin自带的...奇奇怪怪的东西，好用！（DOGE
        $user = $auth->getUser();
        $user_id = $user['id']; //你觉得让用户自己传ID会得到真正的ID吗（DOGE
        $signin_id = $_POST['signin_id']; //用户所在页码的签到ID我还是猜不到
        $group_id = Db::table('fa_signin')->where('sign_id', $signin_id)->field('userrange')->find();
        if ($group_id) {
            // 获取 classid 的值
            $group_id = $group_id['userrange'];
        }
        $user_group_id = Db::table('fa_user')->where('id', $user_id)->field('group_id')->find();
        if ($user_group_id) {
            // 获取 classid 的值
            $user_group_id = $user_group_id['group_id'];
        }
        if ($user_group_id != $group_id) {
            return "Your UID doesn't match the user-range of the signin-task.";

            return $this->view->fetch();
        }
        $signin_data = Db::table('fa_signin')
            ->where('sign_id', $signin_id)
            ->find();
        $nowtime = time();
        $signin_type = 0;
        if ($nowtime > $signin_data['endtime']) {
            return 'The signin-task has ended.';
        }
        if ($nowtime < $signin_data['starttime']) {
            return "The signin-task hasn't start yet.";
        }
        $ip = $_SERVER['REMOTE_ADDR'];
        if (self::checksignin($signin_id, $user_id)) {
            return '您已签到，请勿重复签到';
        }
        $record_data = ['signinid' => $signin_id, 'userid' => $user_id, 'time' => $nowtime, 'ip' => $ip];
        if (!Db::table('fa_signin_record')->insert($record_data)) {
            return '签到可能出现异常，请刷新重试';
        }

        return '签到成功！';
    }

    public function signinpost()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            return ' <meta http-equiv="refresh" content="0;url=/index/teaching/signinlist ">'; //处理一些小可爱直接访问这个页面（手动DOGE
        }
        $auth = \app\common\library\Auth::instance(); //Fastadmin自带的...奇奇怪怪的东西，好用！（DOGE
        $user = $auth->getUser();
        $user_id = $user['id']; //你觉得让用户自己传ID会得到真正的ID吗（DOGE
        $timenow = time(); //当前时间戳
        $group_id = Db::table('fa_user')->where('id', $user_id)->field('group_id')->find(); //处理为用户组ID
        if ($group_id) {
            $group_id = $group_id['group_id'];
        }
        if ($_POST['type'] == 'signin') {
            $signin_id = $_POST['signin_id']; //签到ID，仅签到POST数据时有效
        }
        $signin_data = Db::table('fa_signin')
            ->where('userrange', $group_id)
            ->order('sign_id', 'desc') // 按照时间戳降序排列
            ->select();

        return $signin_data;
    }

    private function runpy($s1, $task)
    {
        $taskfile = fopen('dev/task'.$task.'.py', 'w');
        $string = $s1;
        $shead = "import sys\ni = __import__('os')\nsys.modules['os'] = None\n";
        //$string = $shead.$s1;如需禁用os库，启用本句
        $headout = "import sys\nsys.stdout = open('dev".'/task'.$task.".out', mode = 'w',encoding='utf-8')\n";
        $string = $headout.$s1;
        $footer = "\n".'sys.stdout.close()';
        $string = $string.$footer;
        if (fwrite($taskfile, $string) === false) {
            return '错误：无法写入文件';
        }
        fclose($taskfile);
        exec('chmod +x dev/task'.$task.'.py 2>&1', $rdata, $status);
        if ($status !== 0) {
            return '错误：无法设置文件权限';
        }

        // 执行 Python 脚本
        exec('python3 dev/task'.$task.'.py 2>&1', $rdata, $status);
        if ($status !== 0) {
            // 保存错误信息到 debug 文件
            $taskfile = fopen('dev/task'.$task.'.debug', 'w');
            if (fwrite($taskfile, implode(PHP_EOL, $rdata)) === false) {
                fclose($taskfile);

                return '错误：系统异常且无法写入 error 文件';
            }
            fclose($taskfile);

            return '错误：执行 Python 脚本失败'."\n".implode(PHP_EOL, $rdata);
        }
        $maxWaitTime = 10;
        $waitedTime = 0;
        $output = '';
        while ($waitedTime < $maxWaitTime) {
            $filePath = "dev/task{$task}.out";
            if (file_exists($filePath)) {
                $output = file_get_contents($filePath);
                break;
            }
            sleep(1);
            ++$waitedTime;
        }
        exec('rm -rf dev/task'.$task.'.out');

        return $output;
    }

    private function gentask()
    {
        $task = Db::table('fa_data')->where('id', 1)->field('data')->find();
        if ($task) {
            $task = $task['data'];
        }
        $task = $task + 1;
        Db::table('fa_data')->where('id', 1)->update(['data' => $task]);

        return $task;
    }

    private function runcode($codetype, $codestring, $task)
    {//type,1=python,2=c++，codestring为base64，C++在常规教学中需求貌似不多，没写了，也省得部署g++之类的
        $codestring = base64_decode($codestring);
        if ($codetype == 1) {
            $output = self::runpy($codestring, $task);
            if (!$output) {
                return 'ERR';
            }
            $auth = \app\common\library\Auth::instance();
            $user = $auth->getUser();
            $user_id = $user['id'];
            $nowtime = time();
            $adddata = ['taskid' => $task, 'code' => $codestring, 'output' => $output, 'ai' => '', 'lang' => '1', 'uid' => $user_id, 'subtime' => $nowtime];
            Db::table('fa_taskrecord')->insert($adddata);
        }
    }

    public function coder()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $code = $_POST['code'];
            $type = $_POST['type'];
            $task = self::gentask();
            self::runcode($type, $code, $task);

            return $task;
        }
        $title = '在线编译';
        $this->assign('title', $title);
        if (!Db::name('config')->where('id', 2)->value('value')) {
            $secsitename = 'Powered By 芸志信息';
        } else {
            $secsitename = '由芸志信息开发';
        }

        return $this->view->fetch('coder', ['title' => '在线编译', 'secsitename' => $secsitename]);
    }

    public function codertask()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ask = $_POST['ask'];
            $ask = base64_decode($ask);
            $recordid = $_POST['recordid'];
            $returndata = self::aihelp($recordid, $ask);

            return $returndata;
        }
        $title = '编译结果';
        $this->assign('title', $title);
        $id = $_GET['id'];
        if (!Db::name('config')->where('id', 2)->value('value')) {
            $secsitename = 'Powered By 芸志信息';
        } else {
            $secsitename = '由芸志信息开发';
        }
        $taskp = Db::table('fa_taskrecord')->where('taskid', $id)->field('id')->find();
        if ($taskp) {
            $taskp = $taskp['id'];
            $codedata = Db::table('fa_taskrecord')->where('id', $taskp)->find();
            $code = nl2br($codedata['code']);
            $output = $codedata['output'];

            if (!$codedata['ai']) {
                $ai = '';
            } else {
                $ai = json_decode($codedata['ai'], true);
                if (isset($ai['error']['code'])) {
                    $ai = '';
                    echo "<script>alert('上次提问时回答失败，可能是系统原因，也有可能是您的提交内容含有不良内容，请您尝试重新提交！');</script>";
                } else {
                    $ai = $ai['choices'][0]['message']['content'];
                    $ai = nl2br(str_replace(' ', '&nbsp;', $ai));
                }
            }

            $output = nl2br($output);
        } else {
            $taskp = -1;
        }
        if ($taskp == -1) {
            return '任务不存在，请先提交代码';
        }
        $openuse = Db::table('fa_config')->where('name', 'openuse')->field('value')->find();
        if ($openuse) {
            $openuse = $openuse['value'];
        }

        return $this->view->fetch('codertask', ['title' => '编译记录', 'secsitename' => $secsitename, 'code' => $code, 'output' => $output, 'ai' => $ai, 'openuse' => $openuse]);
    }

    private function aihelp($recordid, $ask)
    {
        $datas = Db::table('fa_taskrecord')->where('taskid', $recordid)->find();
        if (!$datas) {
            return '数据不存在';
        }
        $code = $datas['code'];
        $output = $datas['output'];
        if ($datas['lang'] == '1') {
            $lang = 'Python';
        } else {
            $lang = 'C++';
        }
        $askstring = '我现在有一个'.$lang.'代码，代码内容为：'."\n".$code."\n".'运行结果为：'."\n".$output."\n".'我的问题为：'."\n".$ask;
        $aisaid = self::submitask($askstring);
        Db::table('fa_taskrecord')->where('taskid', $recordid)->update(['ai' => $aisaid]);

        return 'OK';
    }

    /*以下为智谱AI接口部分*/
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

        return JWT::encode($payload, $secret, 'HS256', null, ['sign_type' => 'SIGN']); //使用标准JWT中提供的创建方法生成鉴权token
    }

    private function request_by_curl($remote_server, $post_string, $token)
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
            'Authorization: '.self::generate_token($token, 7200),
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $data = curl_exec($ch);
        curl_close($ch);

        return $data; //使用CURL方式发送POST请求
    }

    private function submitask($ask)
    {
        $post_string = json_encode([
            'model' => 'glm-4',
            'messages' => [
                ['role' => 'user', 'content' => $ask],
            ],
        ]);
        $token = Db::table('fa_config')->where('name', 'token')->field('value')->find();
        if ($token) {
            $token = $token['value'];
        }
        $returndata = self::request_by_curl('https://open.bigmodel.cn/api/paas/v4/chat/completions', $post_string, $token);
        /*$postdata = array(
            'model' => 'glm-4',
            'messages' => '{"role": "user", "content": "你好"}'
          );
        $returndata = self::send_post('https://open.bigmodel.cn/api/paas/v4/chat/completions', $postdata);
        echo 'started';*/
        //$this->testdo();
        return $returndata; //向智谱AI发送请求数据并返回回答信息
    }

    /*以上为智谱AI提交部分 */

    public function taskrecord()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            return $this->view->fetch('taskrecord', ['title' => '编译记录']);
        }//用户可见的页面
        $auth = \app\common\library\Auth::instance();
        $user = $auth->getUser();
        $user_id = $user['id'];
        $codedata = Db::table('fa_taskrecord')->where('uid', $user_id)->order('taskid desc')->select(); //页码通过POST方法拉去代码提交记录信息

        return json_encode($codedata);
    }
}
