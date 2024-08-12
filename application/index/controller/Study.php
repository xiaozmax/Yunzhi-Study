<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use Firebase\JWT\JWT;
use think\Db;

/**
 * 会员中心.
 */
class Study extends Frontend
{
    protected $layout = 'default';
    protected $noNeedLogin = [];
    protected $noNeedRight = ['*'];

    public function index()
    {
        return $this->view->fetch('index', ['title' => '任务中心']);
    }

    public function post_for_studytask()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            return ' <meta http-equiv="refresh" content="0;url=/index/study/index ">'; //处理一些小可爱直接访问这个页面（手动DOGE
        }
        $auth = \app\common\library\Auth::instance(); //Fastadmin自带的...奇奇怪怪的东西，好用！（DOGE
        $user = $auth->getUser();
        $user_id = $user['id']; //你觉得让用户自己传ID会得到真正的ID吗（DOGE
        //$timenow = time(); //当前时间戳
        $group_id = Db::name('user')->where('id', $user_id)->field('group_id')->find(); //处理为用户组ID
        if ($group_id) {
            $group_id = $group_id['group_id'];
        }
        $studytask_data = Db::name('studytask')
            ->where('class_id', $group_id)
            ->order('id', 'desc') // 按照时间戳降序排列
            ->select();

        return $studytask_data;
    }

    public function page()
    {
        $auth = \app\common\library\Auth::instance();
        $user = $auth->getUser();
        $user_id = $user['id'];
        $study_task_id = $_GET['study_task_id'];
        $study_task_data = Db::name('studytask')->where('id', $study_task_id)->find();
        $study_task_content = $study_task_data['content'];
        $study_task_name = $study_task_data['title'];
        $study_task_record_data = Db::name('studytaskrecord')
            ->where('study_taskid', $study_task_id)
            ->where('uid', $user_id)
            ->select();
        $code_task_id = '';
        if (!isset($study_task_record_data[0]['id'])) {
            $indata = ['uid' => $user_id, 'study_taskid' => $study_task_id, 'code_task' => '', 'done' => '0'];
            Db::name('studytaskrecord')->insert($indata);
            $output = '';
            $code = '';
            $ai = '';
            $done = '0';
            $teacher = '';
            $askedt = '';
        } elseif (isset($study_task_record_data[0]['id']) && !$study_task_record_data[0]['code_task']) {
            $output = '';
            $code = '';
            $ai = '';
            $done = '0';
            $teacher = '';
            $askedt = '';
        } else {
            $taskid_list = explode('||', $study_task_record_data[0]['code_task']);
            $taskid_list_size = count($taskid_list) - 1;
            $task_record_data = Db::name('taskrecord')->where('taskid', $taskid_list[$taskid_list_size])->select();
            $code_task_id = $taskid_list[$taskid_list_size];
            $teacher = '';
            $askedt = '';
            if (isset($task_record_data[0]['teacher'])) {
                $askedt = $task_record_data[0]['teacher'];
                $teacher = Db::name('questioning')->where('id', $askedt)->select();
                $teacher = $teacher[0]['reply_content'];
            }
            //return json_encode($task_record_data);
            $output = $task_record_data[0]['output'];
            $output = str_replace("\n", '<br/>', $output);
            $code = $task_record_data[0]['code'];
            $ai = $task_record_data[0]['ai'];

            if (!$task_record_data[0]['ai']) {
                $ai = '';
            } else {
                $ai = json_decode($task_record_data[0]['ai'], true);
                if (isset($ai['error']['code'])) {
                    $ai = '';
                    echo "<script>alert('上次提问时回答失败，可能是系统原因，也有可能是您的提交内容含有不良内容，请您尝试重新提交！');</script>";
                } else {
                    $ai = $ai['choices'][0]['message']['content'];
                    $ai = nl2br(str_replace(' ', '&nbsp;', $ai));
                }
            }
            $done = $study_task_record_data[0]['done'];
        }
        $openuse = Db::name('config')->where('name', 'openuse')->field('value')->find();
        if ($openuse) {
            $openuse = $openuse['value'];
        }

        return $this->view->fetch('page', ['title' => '学习任务', 'study_task_name' => $study_task_name, 'output' => $output, 'code' => $code, 'openuse' => $openuse, 'ai' => $ai, 'study_task_id' => $study_task_id, 'study_task_content' => $study_task_content, 'done' => $done, 'askedt' => $askedt, 'teacher' => $teacher, 'code_task_id' => $code_task_id]);
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
        exec('python3 dev/task'.$task.'.py 2>&1', $rdata, $status);
        if ($status !== 0) {
            $taskfile = fopen('dev/task'.$task.'.debug', 'w');
            if (fwrite($taskfile, implode(PHP_EOL, $rdata)) === false) {
                fclose($taskfile);

                return '错误：系统异常且无法写入 error 文件';
            }
            fclose($taskfile);

            return '错误：执行 Python 脚本失败'."\n".implode(PHP_EOL, $rdata);
        }
        $maxWaitTime = 2;
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

        return $output;
    }

    private function gentask()
    {
        $task = Db::name('data')->where('id', 1)->field('data')->find();
        if ($task) {
            $task = $task['data'];
        }
        $task = $task + 1;
        Db::name('data')->where('id', 1)->update(['data' => $task]);

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
            Db::name('taskrecord')->insert($adddata);
        }
    }

    public function askai()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $done = $_POST['done'];
            $study_task_id = $_POST['study_task_id'];
            $returndata = self::aihelp($study_task_id, $done);

            return $returndata;
        }
    }

    private function aihelp($study_task_id, $done)
    {//处理数据，调用submitask函数向AI提问并将回复内容记录进数据库
        $auth = \app\common\library\Auth::instance();
        $user = $auth->getUser();
        $user_id = $user['id'];
        $study_task_data = Db::name('studytask')->where('id', $study_task_id)->select();
        $content = $study_task_data[0]['content'];
        $study_task_record_data = Db::name('studytaskrecord')
            ->where('study_taskid', $study_task_id)
            ->where('uid', $user_id)
            ->select();
        $taskid_list = explode('||', $study_task_record_data[0]['code_task']);
        $taskid_list_size = count($taskid_list) - 1;
        $task_record_data = Db::name('taskrecord')->where('taskid', $taskid_list[$taskid_list_size])->select();
        if (!$task_record_data) {
            return '数据不存在';
        }
        $output = $task_record_data[0]['output'];
        $code = $task_record_data[0]['code'];
        if ($task_record_data[0]['lang'] == '1') {
            $lang = 'Python';
        } else {
            $lang = 'C++';
        }
        $ask = '题目要求为：'.$content."\n";
        if ($done == 1) {
            $ask = $ask.'现在需要你解析代码，如果有更好的解决方案，也可以提出来';
        } else {
            $ask = $ask.'但是结果并不正确，现在需要你检查代码，告诉我错误的原因，并告诉我如何解决问题';
        }
        $askstring = '我现在有一个'.$lang.'代码，代码内容为：'."\n".$code."\n".'运行结果为：'."\n".$output."\n".$ask;
        $aisaid = self::submitask($askstring);
        Db::table('fa_taskrecord')->where('taskid', $taskid_list[$taskid_list_size])->update(['ai' => $aisaid]);

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
    {//POST请求
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
                ['role' => 'user', 'content' => $ask]
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
            return $this->view->fetch();
        }//用户可见的页面
        $auth = \app\common\library\Auth::instance();
        $user = $auth->getUser();
        $user_id = $user['id'];
        $codedata = Db::table('fa_taskrecord')->where('uid', $user_id)->order('taskid desc')->select(); //页码通过POST方法拉去代码提交记录信息

        return json_encode($codedata);
    }

    public function study_task_submit()//处理提交的代码并对比计算结果，判断是否完成学习任务
    {
        $auth = \app\common\library\Auth::instance();
        $user = $auth->getUser();
        $user_id = $user['id'];
        $study_task_id = $_POST['study_task_id'];
        $code = $_POST['code'];
        $type = $_POST['type'];
        $task = self::gentask();
        self::runcode($type, $code, $task);
        $taskdata = Db::name('studytaskrecord')->where('study_taskid', $study_task_id)->where('uid', $user_id)->select();
        if ($taskdata[0]['code_task']) {
            $taskdata = strval($taskdata[0]['code_task']).strval('||').strval($task);
        } else {
            $taskdata = $task;
        }
        Db::name('studytaskrecord')->where('study_taskid', $study_task_id)->where('uid', $user_id)->update(['code_task' => $taskdata]);
        $task_record_data = Db::name('taskrecord')->where('taskid', $task)->select();
        $output = '';
        $filePath = "dev/task{$task}.out";
        if (file_exists($filePath)) {
            $output = file_get_contents($filePath);
            //$output = str_replace(PHP_EOL, '', $output);
            str_replace("\n", '', $output);
        } else {
            return 0;
        }
        //$output = $task_record_data[0]['output'];
        $study_task_data = Db::name('studytask')->where('id', $study_task_id)->select();
        $ans = $study_task_data[0]['ans'];
        $taskfile = fopen($task.'ans.ans', 'w');
        if (fwrite($taskfile, $ans) === false) {
            fclose($taskfile);
        }
        fclose($taskfile);
        //str_replace("\n", '', $ans);
        exec("tr -d '\r\n' < ".$task.'ans.ans > '.$task.'.ans.ans.unix');
        exec("tr -d '\r\n' < dev/task".$task.'.out > dev.'.$task.'.out.unix');
        $filePath = 'dev.'.$task.'.out.unix';
        file_exists($filePath);
        $output = file_get_contents($filePath);
        $filePath = $task.'.ans.ans.unix';
        file_exists($filePath);
        $ans = file_get_contents($filePath);
        if (md5($output) == md5($ans)) {
            echo 'same';
            Db::name('studytaskrecord')->where('study_taskid', $study_task_id)->where('uid', $user_id)->update(['done' => 1]);
        }
        exec('rm -rf '.$task.'.ans.ans.unix');
        exec('rm -rf '.$task.'ans.ans');
        exec('rm -rf dev.'.$task.'.out.unix');
        $outdata = Db::name('taskrecord')->where('taskid', $task)->select();
        $outdata1 = $outdata[0]['output'];
        if (strstr($outdata1, '执行 Python 脚本失败') == null) {
            exec('rm -rf dev/task'.$task.'.out');
        } else {
            return 1;
        }

        return base64_encode(strval(rtrim($output)));

        return $study_task_id;
    }

    public function askt()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = \app\common\library\Auth::instance(); //Fastadmin自带的...奇奇怪怪的东西，好用！（DOGE
            $user = $auth->getUser();
            $user_id = $user['id']; //你觉得让用户自己传ID会得到真正的ID吗（DOGE
            $question = $_POST['ask'];
            $question = base64_decode($question);
            $study_task_id = $_POST['study_task_id'];
            $code_task_id = $_POST['code_task_id'];

            echo $_POST['study_task_id'];
            $done = $_POST['done'];
            $data = ['uid' => $user_id, 'study_taskid' => $study_task_id, 'content' => $question, 'task_record_id' => $code_task_id];
            $returndata = Db::name('questioning')->insertGetId($data);
            $study_task_record_data = Db::name('studytaskrecord')
            ->where('study_taskid', $study_task_id)
            ->where('uid', $user_id)
            ->select();
            $taskid_list = explode('||', $study_task_record_data[0]['code_task']);
            $taskid_list_size = count($taskid_list) - 1;
            $task_record_data = Db::name('taskrecord')->where('taskid', $taskid_list[$taskid_list_size])->select();
            Db::name('taskrecord')->where('taskid', $taskid_list[$taskid_list_size])->update(['teacher' => $returndata]);

            return $returndata;
        }

        return 'err';
    }
}
