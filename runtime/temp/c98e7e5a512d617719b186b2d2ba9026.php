<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:73:"/www/wwwroot/code/public/../application/index/view/index/content_new.html";i:1715611782;}*/ ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>云端智学轩-信息技术学科专题网站</title>
    <!-- web-fonts -->
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,700,500' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <!-- off-canvas -->
    <link href="/assets/css/mobile-menu.css" rel="stylesheet">
    <!-- font-awesome -->
    <link href="/assets/fonts/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css"
        integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <!-- Style CSS -->
    <link href="/assets/css/style.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<body>
    <div id="main-wrapper">
        <!-- Page Preloader -->
        <div id="preloader">
            <div id="status">
                <div class="status-mes"></div>
            </div>
        </div>

        <div class="uc-mobile-menu-pusher">

            <div class="content-wrapper">
                <nav class="navbar m-menu navbar-default navbar-fixed-top">
                    <div class="container">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                data-target="#navbar-collapse-1">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a class="navbar-brand" href="index"><img src="img/logo.png" alt=""></a>
                        </div>


                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse" id="#navbar-collapse-1">

                            <!--<ul class="nav-cta hidden-xs">
                <li class="dropdown"><a href="#" data-toggle="dropdown" class="dropdown-toggle"><i
                        class="fa fa-search"></i></a>
                    <ul class="dropdown-menu">
                        <li>
                            <div class="head-search">
                                <form role="form">-->
                            <!-- Input Group -->
                            <!--<div class="input-group">
                                        <input type="text" class="form-control" placeholder="Type Something">
			                                <span class="input-group-btn">
			                                  <button type="submit" class="btn btn-primary">Search</button>
			                                </span>
                                    </div>
                                </form>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>-->

                            <ul class="nav navbar-nav navbar-right main-nav">
                                <li><a href="index.html">主页</a></li>
                                <li class="active"><a href="/index/index/contentlist.html">内容中心</a></li>
                                <li><a href="/index/index/help.html">帮助中心</a></li>
                                <li><a href="/index/index/about.html">关于我们</a></li>
                                <ul class="navbar-nav ms-auto mb-2 mb-lg-0"> <!-- 使用 ms-auto 类来右对齐 -->
                                    <?php if(isset($user)): ?>
                                    <!-- 用户已登录，显示用户头像和ID -->
                                    <li class="">
                                        <a class="nav-link" href="<?php echo url('user/index'); ?>">
                                            <img src="<?php echo $user['avatar']; ?>" alt="用户头像" class="user-avatar rounded-circle me-2"
                                                style="width: 35px; height: 35px;">
                                            <?php echo $user['nickname']; ?>
                                        </a>
                                    </li>
                                    <?php else: ?>
                                    <!-- 用户未登录，显示登录/注册链接 -->
                                    <li class="">
                                        <button type="button" class="btn btn-primary"
                                            onclick="location.href='<?php echo url('user/login'); ?>'"
                                            style="border-radius: 25px;">登录</button>
                                        <button type="button" class="btn btn-light"
                                            onclick="location.href='<?php echo url('user/register'); ?>'"
                                            style="border-radius: 25px;">注册</button>
                                    </li>
                                    <?php endif; ?>
                                </ul>

                            </ul>

                        </div>
                        <!-- .navbar-collapse -->
                    </div>
                    <!-- .container -->
                </nav>
                <!-- .nav -->

                <div id="x-corp-carousel" class="carousel slide hero-slide hidden-xs" data-ride="carousel">
                    <div class="carousel-inner" role="listbox">
                    </div>
                </div>
                <div class="single-page-title2">
                    <div class="container text-center">
                        <h2>阅读文章</h2>
                    </div>
                </div>
                <my-div class="article-place">
                    <script>
                        $(document).ready(function () {
                            // 检查 URL 中的查询参数
                            var urlParams = new URLSearchParams(window.location.search);
                            var articleId = urlParams.get('id');

                            // 更新 iframe 的 src 属性
                            $('#article-frame').attr('src', '/index/index/contentdat?id=' + articleId);
                            // 监听 iframe 内容加载事件
                            $('#article-frame').load(function () {
                                // 获取 iframe 内容的高度
                                var iframeContentHeight = $('#article-frame').contents().height();

                                // 设置 iframe 的高度
                                $('#article-frame').css('height', iframeContentHeight + 'px');
                            });
                        });

                    </script>
                    <iframe id="article-frame" src="/index/index/contentdat" frameborder="0"
                        style="min-height:50vh ;width: 100%;margin-top: 2%;"></iframe>

                </my-div>
                <button onclick="location.href=('/index/index/contentlist')" class="btn btn-primary" style="border-radius: 0.5em;margin-left: 2%;margin-bottom: 2%;">返回文章列表</button>
                <footer class="footer">
                    <div class="footer-widget-section"></div>
                    <div class="copyright-section">
                        <div class="container clearfix">
                            <span class="copytext">Copyright &copy; 2024 | <a
                                    title="松原市宁江区芸志信息技术工作室（个体工商户）">芸志信息</a></span>

                            <!--<ul class="list-inline pull-right">
                                <li><a href="/index.html">主页</a></li>
                                <li class="active"><a href="/index/index/contentlist.html">内容中心</a></li>
                                <li><a href="/index/index/help.html">帮助中心</a></li>
                                <li><a href="/index/index/about.html">关于我们</a></li>
                                <li><a href="/index/user/login.html">登录/注册</a></li>
                                <li><a href="#">Contact</a></li>
                            </ul>-->
                        </div><!-- .container -->
                    </div><!-- .copyright-section -->
                </footer>
                <!-- .footer -->

            </div>
            <!-- .content-wrapper -->
        </div>
        <!-- .offcanvas-pusher -->

        <div class="uc-mobile-menu uc-mobile-menu-effect">
            <button type="button" class="close" aria-hidden="true" data-toggle="offcanvas"
                id="uc-mobile-menu-close-btn">&times;</button>
            <div>
                <div>
                    <ul id="menu">
                        <li><a href="/index">主页</a></li>
                        <li><a href="/index/index/contentlist.html">内容中心</a></li>
                        <li><a href="/index/index/help.html">帮助中心</a></li>
                        <li class="active"><a href="#">关于我们</a></li>
                        <li><a href="/index/user/login.html">登录/注册</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- .uc-mobile-menu -->

    </div>
    <!-- #main-wrapper -->


    <!-- Script -->
    <script src="/assets/js/jquery-2.1.4.min.js"></script>
    <script src="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js"
        integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
        crossorigin="anonymous"></script>
    <script src="/assets/js/smoothscroll.js"></script>
    <script src="/assets/js/mobile-menu.js"></script>
    <script src="/assets/js/flexSlider/jquery.flexslider-min.js"></script>
    <script src="/assets/js/scripts.js"></script>
    <div />

    </div>
</body>

</html>