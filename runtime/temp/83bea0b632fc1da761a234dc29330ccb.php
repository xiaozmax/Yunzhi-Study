<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:96:"/www/wwwroot/view.yunzhixinxi.com_18001/public/../application/index/view/teaching/signinnow.html";i:1710642349;s:82:"/www/wwwroot/view.yunzhixinxi.com_18001/application/index/view/layout/default.html";i:1689043529;s:79:"/www/wwwroot/view.yunzhixinxi.com_18001/application/index/view/common/meta.html";i:1710566795;s:82:"/www/wwwroot/view.yunzhixinxi.com_18001/application/index/view/common/sidenav.html";i:1716984943;s:81:"/www/wwwroot/view.yunzhixinxi.com_18001/application/index/view/common/script.html";i:1710516990;}*/ ?>
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
    <style>
        .table th, .table td {
            white-space: nowrap; /* 防止文本换行 */
            text-overflow: ellipsis; /* 超出部分显示省略号 */
            overflow: hidden; /* 隐藏超出部分 */
            max-width: 150px; /* 设置最大宽度，可以根据需要调整 */
        }
        
        /* 如果您想要在较小的屏幕上调整表格布局 */
        @media (max-width: 768px) {
            .table th, .table td {
                max-width: 100px; /* 在小屏幕上减少最大宽度 */
            }
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
                    <h2 class="page-header">
                        <?php echo __('attendance'); ?>
                        <a href="<?php echo url('teaching/signinlist'); ?>" class="btn btn-primary pull-right">返回签到列表</a>
                    </h2>
                    <!-- 添加一个不可见的元素来存储用户 ID -->
                    <span id="userId" style="display:none;"><?php echo $user['id']; ?></span>
                    <div class="row user-baseinfo">
                        <?php if($can_signin != 0): ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <h3><strong>签到名称：</strong><?php echo $signin_name; ?></h3>
                                <h3><strong>起始时间：</strong><?php echo $start_time; ?></h3>
                                <h3><strong>结束时间：</strong><?php echo $end_time; ?></h3>
                                <?php if($signin_type == 'on'): ?>
                                <h3><strong>目前状态：</strong>正在进行</h3>
                                <?php elseif($signin_type == 'ended'): ?>
                                <h3><strong>目前状态：</strong>已结束</h3>
                                <?php else: ?>
                                <h3><strong>目前状态：</strong>未开始</h3>
                                <?php endif; if($signin_type != 'waiting'): if($user_type == 1): ?>
                                <h3><strong>签到状态：</strong>已签到</h3>
                                <?php else: ?><h3><strong>签到状态：</strong>未签到</h3>
                                <?php endif; endif; ?>
                            </table>
                        </div>
                        <?php if($signin_type == 'on'): if($user_type != 1): ?>
                        <button id="signinButton">签到</button>
                        <script>
                        // 获取按钮元素
                            var signinButton = document.getElementById('signinButton');
                            
                            // 绑定点击事件处理函数
                            signinButton.addEventListener('click', function() {
                                // 获取 URL 中的 signin_id 参数
                                var signinId = window.location.search.match(/signin_id=([^&]+)/);
                                if (signinId && signinId.length > 1) {
                                    signinId = signinId[1];
                                } else {
                                    console.error('signin_id 参数未找到');
                                    return;
                                }
                            
                                // 创建一个 FormData 对象
                                var formData = new FormData();
                            
                                // 添加 signin_id 参数到 FormData 对象
                                formData.append('signin_id', signinId);
                            
                                // 发送 POST 请求
                                fetch('/index/teaching/signinnow', {
                                    method: 'POST',
                                    body: formData
                                })
                                .then(response => {
                                    if (!response.ok) {
                                        throw new Error('网络响应错误');
                                    }
                                    // 由于返回的数据是文本，不是 JSON，所以直接返回文本
                                    return response.text();
                                })
                                .then(text => {
                                    // 处理响应文本
                                    console.log('签到响应：', text);
                                    alert("签到结果：" + text);
                                    location.reload();
                                    // 根据响应文本更新页面或显示消息
                                    // 例如，您可以使用 text 更新页面上的某个元素
                                })
                                .catch(error => {
                                    // 处理请求错误
                                    console.error('签到请求失败：', error);
                                    alert("错误信息：" + text)
                                });
                            });
                            
                            </script>
                            <?php endif; endif; else: ?>
                        <h1 style="color: red;">对不起，您没有权限进行本次签到</h1>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
        </main>

        <footer class="footer" style="clear:both">
            <p class="copyright">Copyright&nbsp;©&nbsp;<?php echo date("Y"); ?> <?php echo htmlentities($site['name'] ?? ''); ?> All Rights Reserved <a href="https://beian.miit.gov.cn" target="_blank"><?php echo htmlentities($site['beian'] ?? ''); ?></a></p>
        </footer>

        <script src="/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/assets/js/require-frontend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo htmlentities($site['version'] ?? ''); ?>"></script>


    </body>

</html>
