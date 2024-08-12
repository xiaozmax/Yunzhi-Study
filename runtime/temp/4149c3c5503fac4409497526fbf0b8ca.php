<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:75:"/www/wwwroot/code/public/../application/index/view/teaching/taskrecord.html";i:1711176571;s:60:"/www/wwwroot/code/application/index/view/layout/default.html";i:1689043529;s:57:"/www/wwwroot/code/application/index/view/common/meta.html";i:1710566795;s:60:"/www/wwwroot/code/application/index/view/common/sidenav.html";i:1716984943;s:59:"/www/wwwroot/code/application/index/view/common/script.html";i:1710516990;}*/ ?>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetchData();

            function fetchData() {
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '/index/teaching/taskrecord', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        var data = JSON.parse(xhr.responseText);
                        populateTable(data);
                    }
                };
                xhr.send();
            }

            function populateTable(data) {
                var table = document.getElementById('taskTable');
                table.innerHTML = ''; // Clear existing table data

                // Create table header
                var thead = document.createElement('thead');
                var headerRow = document.createElement('tr');
                headerRow.innerHTML = '<th>任务ID</th><th>代码内容</th><th>输出内容</th><th>提交时间</th>';
                thead.appendChild(headerRow);
                table.appendChild(thead);

                // Create table body
                var tbody = document.createElement('tbody');
                data.forEach(function(row) {
                    var subtime = new Date(row.subtime * 1000).toLocaleString();
                    var tr = document.createElement('tr');
                    tr.innerHTML = '<td>' + row.taskid + '</td>' +
                                   '<td>' + row.code.substring(0, 50) + '...</td>' +
                                   '<td>' + row.output.replace(/\n/g, ' ').substring(0, 100) + '...</td>' +
                                   '<td>' + subtime + '</td>' +
                                   '<td><a href="/index/teaching/codertask?id=' + row.taskid + '">查看任务</a></td>';
                    tbody.appendChild(tr);
                });
                table.appendChild(tbody);
            }
        });
    </script>
</head>
<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    table,
    th,
    td {
        border: 1px solid black;
    }

    th,
    td {
        padding: 8px;
        text-align: left;
    }

    tr:hover {
        background-color: #f5f5f5;
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
                    <h1>任务记录</h1>
                    <table id="taskTable">
                        <!-- Table data will be populated here -->
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

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
