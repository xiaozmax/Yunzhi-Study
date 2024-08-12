<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:92:"/www/wwwroot/view.yunzhixinxi.com_18001/public/../application/index/view/teaching/coder.html";i:1711360492;s:82:"/www/wwwroot/view.yunzhixinxi.com_18001/application/index/view/layout/default.html";i:1689043529;s:79:"/www/wwwroot/view.yunzhixinxi.com_18001/application/index/view/common/meta.html";i:1710566795;s:82:"/www/wwwroot/view.yunzhixinxi.com_18001/application/index/view/common/sidenav.html";i:1716984943;s:81:"/www/wwwroot/view.yunzhixinxi.com_18001/application/index/view/common/script.html";i:1710516990;}*/ ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
<title><?php echo htmlentities((isset($title) && ($title !== '')?$title:'') ?? ''); ?> – <?php echo htmlentities($site['name'] ?? ''); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta name="renderer" content="webkit">

<?php if(isset($keywords)): ?>
<meta name="keywords" content="<?php echo htmlentities($keywords ?? ''); ?>">
<?php endif; if(isset($description)): ?>
<meta name="description" content="<?php echo htmlentities($description ?? ''); ?>">
<?php endif; ?>

<link rel="shortcut icon" href="/assets/img/favicon.ico" />

<link href="/assets/css/frontend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.css?v=<?php echo htmlentities(\think\Config::get('site.version') ?? ''); ?>"rel="stylesheet">

<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
<!--[if lt IE 9]>
  <script src="/assets/js/html5shiv.js"></script>
  <script src="/assets/js/respond.min.js"></script>
<![endif]-->
<script type="text/javascript">
  var require = {config: <?php echo json_encode($config ?? ''); ?>};
</script>
<!-- 引入 jQuery -->
<script src="/assets/js/js/jquery-3.7.1.min.js"></script>

<!-- 引入 Bootstrap JS -->
<script src="/assets/js/js/bootstrap.bundle.min.js"></script>

        <link href="/assets/css/user.css?v=<?php echo htmlentities(\think\Config::get('site.version') ?? ''); ?>" rel="stylesheet">
    </head>

    <body>

        <nav class="navbar navbar-white navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#header-navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo url('/'); ?>"><?php echo htmlentities($site['name'] ?? ''); ?></a>
                </div>
                <div class="collapse navbar-collapse" id="header-navbar">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="<?php echo url('/'); ?>"><?php echo __('Home'); ?></a></li>
                        <li class="dropdown">
                            <?php if($user): ?>
                            <a href="<?php echo url('user/index'); ?>" class="dropdown-toggle" data-toggle="dropdown">
                                <span class="avatar-img"><img src="<?php echo cdnurl(htmlentities($user['avatar'] ?? '') ?? ''); ?>" alt=""></span>
                                <span class="visible-xs-inline-block" style="padding:5px;"><?php echo $user['nickname']; ?> <b class="caret"></b></span>
                            </a>
                            <?php else: ?>
                            <a href="<?php echo url('user/index'); ?>" class="dropdown-toggle" data-toggle="dropdown"><?php echo __('Member center'); ?> <b class="caret"></b></a>
                            <?php endif; ?>
                            <ul class="dropdown-menu">
                                <?php if($user): ?>
                                <li><a href="<?php echo url('user/index'); ?>"><i class="fa fa-user-circle fa-fw"></i><?php echo __('User center'); ?></a></li>
                                <li><a href="<?php echo url('user/profile'); ?>"><i class="fa fa-user-o fa-fw"></i><?php echo __('Profile'); ?></a></li>
                                <li><a href="<?php echo url('user/changepwd'); ?>"><i class="fa fa-key fa-fw"></i><?php echo __('Change password'); ?></a></li>
                                <li><a href="<?php echo url('user/logout'); ?>"><i class="fa fa-sign-out fa-fw"></i><?php echo __('Sign out'); ?></a></li>
                                <?php else: ?>
                                <li><a href="<?php echo url('user/login'); ?>"><i class="fa fa-sign-in fa-fw"></i> <?php echo __('Sign in'); ?></a></li>
                                <li><a href="<?php echo url('user/register'); ?>"><i class="fa fa-user-o fa-fw"></i> <?php echo __('Sign up'); ?></a></li>
                                <?php endif; ?>

                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="content">
            <!-- 在表格的 <style> 标签中添加 CSS -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
</head>
<style>
    #ceditor {
        height: 50vh;
        /* 设置一个高度 */
        width: 100%;
        /* 设置一个宽度 */
        border: 1px solid #ccc;
        /* 添加一个边框以便可视化 */
    }
</style>

<div id="content-container" class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="sidebar-toggle"><i class="fa fa-bars"></i></div>
<div class="sidenav" id="sidebar-nav">
    <?php echo hook('user_sidenav_before'); ?>
    <ul class="list-group">
        <li class="list-group-heading"><?php echo __('Member center'); ?></li>
        <li class="list-group-item <?php echo check_nav_active('user/index'); ?>"> <a href="<?php echo url('user/index'); ?>"><i
                    class="fa fa-user-circle fa-fw"></i> <?php echo __('User center'); ?></a> </li>
        <li class="list-group-item <?php echo check_nav_active('user/profile'); ?>"> <a href="<?php echo url('user/profile'); ?>"><i
                    class="fa fa-user-o fa-fw"></i> <?php echo __('Profile'); ?></a> </li>
        <li class="list-group-item <?php echo check_nav_active('user/attendance'); ?>"> <a href="<?php echo url('teaching/signinlist'); ?>"><i
                    class="fa fa-check-square"></i> <?php echo __('attendance'); ?></a> </li>
        <li class="list-group-item <?php echo check_nav_active('user/study'); ?>"> <a href="<?php echo url('study/index'); ?>"><i
                    class="fa fa-book"></i> 任务中心</a> </li>
        <li class="list-group-item <?php echo check_nav_active('user/coder'); ?>"> <a href="<?php echo url('teaching/coder'); ?>"><i
                    class="fa fa-code"></i> 在线编译</a> </li>
        <li class="list-group-item <?php echo check_nav_active('user/codertask'); ?>"> <a href="<?php echo url('teaching/taskrecord'); ?>"><i
                    class="fa fa-tasks"></i> 编译记录</a> </li>
        <li class="list-group-item <?php echo check_nav_active('user/changepwd'); ?>"> <a href="<?php echo url('user/changepwd'); ?>"><i
                    class="fa fa-key fa-fw"></i> <?php echo __('Change password'); ?></a> </li>
        <li class="list-group-item <?php echo check_nav_active('user/logout'); ?>"> <a href="<?php echo url('user/logout'); ?>"><i
                    class="fa fa-sign-out fa-fw"></i> <?php echo __('Sign out'); ?></a> </li>
    </ul>
    <?php echo hook('user_sidenav_after'); ?>
</div>
        </div><!--列表-->
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div id="ceditor" class="ceditor"></div>
                    <button class="btn btn-default" onclick="increaseFontSize()">增大字体</button>
                    <button class="btn btn-default" onclick="decreaseFontSize()">减小字体</button>
                    <button class="btn btn-default" id="toggleFullScreen">切换全屏</button>
                    <!-- 添加一个下拉列表用于切换语言 -->
                    <!--<div class="form-group">
                        <label class="control-label">选择语言</label>
                        <select class="form-control selectpicker" id="language-selector">
                            <option value="python">Python</option>
                            <option value="c_cpp">C/C++</option>
                        </select>
                    </div>-->

                    <div class="row mt-2">
                        <div class="col-md-12 text-end">
                            <button class="btn btn-primary" onclick="submitCode()">提交编译</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.bootcss.com/ace/1.4.6/ace.js"></script>
<script src="https://cdn.bootcss.com/ace/1.4.6/ext-beautify.js"></script>
<script src="https://cdn.bootcss.com/ace/1.4.6/ext-language_tools.js"></script>
<script src="https://cdn.bootcss.com/ace/1.4.6/mode-javascript.js"></script>
<script src="https://cdn.bootcss.com/ace/1.4.6/theme-xcode.js"></script>
<script src="https://cdn.bootcss.com/ace/1.4.6/mode-python.js"></script>
<script src="https://cdn.bootcss.com/ace/1.4.6/mode-c_cpp.js"></script>
<script>
    var editor = ace.edit('ceditor');
    editor.setTheme('ace/theme/twilight');
    editor.session.setMode('ace/mode/python');

    // 监听下拉框的变更事件
    /*document.getElementById('language-selector').addEventListener('change', function (event) {
        var selectedLanguage = event.target.value;
        switch (selectedLanguage) {
            case 'python':
                editor.session.setMode('ace/mode/python');
                break;
            case 'c_cpp':
                editor.session.setMode('ace/mode/c_cpp');
                break;
        }
    });*/

    function submitCode() {
        var code = editor.getValue();
        //let selectedLanguage = document.getElementById('language-selector').value;
        //let type = (selectedLanguage === 'python') ? 1 : 2;
        let encodedCode = window.btoa(unescape(encodeURIComponent(code)));

        // 准备POST请求的数据
        const data = new URLSearchParams({
            'code': encodedCode,
            'type': 1
        });

        // 发送POST请求
        fetch('/index/teaching/coder', {
            method: 'POST',
            body: data
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text(); // 解析响应文本
            })
            .then(taskId => {
                // 获取返回的数字并跳转到新的URL
                window.location.href = `/index/teaching/codertask?id=${taskId}`;
            })
            .catch(error => {
                console.error('There has been a problem with your fetch operation:', error);
            });
    }

    function increaseFontSize() {
        var size = editor.getFontSize(); // 获取当前字体大小
        editor.setFontSize(size + 3); // 字体大小加1
    }

    // 减小字体大小
    function decreaseFontSize() {
        var size = editor.getFontSize(); // 获取当前字体大小
        editor.setFontSize(size - 3); // 字体大小减1
    }

    var toggleFullScreenButton = document.getElementById("toggleFullScreen");

    // 为按钮添加点击事件监听器
    toggleFullScreenButton.addEventListener("click", function () {
        // 判断编辑器当前是否处于全屏模式
        if (editor.isFullScreen) {
            // 如果是全屏模式，退出全屏
            editor.exitFullscreen();
        } else {
            // 如果不是全屏模式，进入全屏
            editor.setOption("maxLines", Infinity); // 设置最大行数为无限，以允许编辑器高度扩展
            editor.container.requestFullscreen(); // 使用HTML5全屏API请求全屏
        }
    });
</script>



<!--<script>
    var editor = ace.edit('ceditor');
    editor.setTheme('ace/theme/twilight');
    var jsMode = ace.require('ace/mode/python').Mode;
    editor.session.setMode(new jsMode());
    function submitCode() {
        var code = editor.getValue();
        console.log(code);
        let encodedcode = window.btoa(code);
        console.log('t1', encodedcode);
        // 这里可以添加代码提交的逻辑
    }
</script>-->
        </main>

        <footer class="footer" style="clear:both">
            <p class="copyright">Copyright&nbsp;©&nbsp;<?php echo date("Y"); ?> <?php echo htmlentities($site['name'] ?? ''); ?> All Rights Reserved <a href="https://beian.miit.gov.cn" target="_blank"><?php echo htmlentities($site['beian'] ?? ''); ?></a></p>
        </footer>

        <script src="/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/assets/js/require-frontend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo htmlentities($site['version'] ?? ''); ?>"></script>


    </body>

</html>
