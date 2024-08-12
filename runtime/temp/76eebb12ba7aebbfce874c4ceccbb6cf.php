<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:71:"/www/wwwroot/code/public/../application/index/view/index/index_new.html";i:1715611674;}*/ ?>
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

                            <ul class="nav navbar-nav navbar-right main-nav">
                                <li class="active"><a href="#">主页</a></li>
                                <li><a href="/index/index/contentlist.html">内容中心</a></li>
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
                    <!-- Indicators -->

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox" style="cursor: pointer;">
                        <div class="item active" onselectstart="return false">
                            <img src="/assets/img/hero-slide-1.png" alt="Hero Slide" draggable="false"
                                oncontextmenu="return false;">

                            <div class="carousel-caption">
                                <br>
                                <!--<a style='font-family:华文行楷;color:rgb(231, 126, 28);font-size:15vh;display: block;text-align:left;'>云端学社</a>-->
                                <div style="text-align: left;width: 60%;">
                                    <div style="
                                font-size: 12vh;
                                width: 100%;
                                display: inline;
                                text-align: left;
                                background: linear-gradient(to right, rgb(255, 253, 208), rgb(255, 255, 255));
                                -webkit-background-clip: text;
                                color: transparent;">
                                        云端学社
                                    </div>
                                </div>
                                <div style="text-align: right;float: right;width: 60%;">
                                    <div style="
                            font-size: 12vh;
                            width: 100%;
                            display: inline;
                            text-align: right;
                            background: linear-gradient(to right, rgb(173, 216, 230), rgb(255, 255, 255));
                            -webkit-background-clip: text;
                            color: transparent;">
                                        智慧信息
                                    </div>
                                </div>

                                <p style="color: rgba(20, 171, 230, 0.336);white-space: pre-line;">



                                    云端智学轩-信息技术专题网站，助力信息技术学科教学发展，集教学资源管理、课堂工具、AI辅助学习等功能于一体的平台</p>
                            </div>
                        </div>

                    </div>

                </div>
                <!-- #x-corp-carousel-->

                <section class="x-services ptb-100 gray-bg">

                    <section class="section-title">
                        <div class="container text-center">
                            <h2>项目优势</h2>
                            <span class="bordered-icon"><i class="fa fa-circle-thin"></i></span>
                        </div>
                    </section>

                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="thumbnail clearfix">
                                    <a style="cursor: pointer;"><img class="img-responsive"
                                            src="/assets/img/img-offer-1.jpg" alt="Image" draggable="false"
                                            oncontextmenu="return false;"></a>

                                    <div class="caption">
                                        <h3><a style="cursor: pointer;">轻量便捷</a></h3>

                                        <p>项目使用轻量化的计算语言编写，同时配合新兴专业级网页服务组建，节省服务器资源的同时加快响应速度，提高提高用户体验和满意度，助力信息技术学科教育发展.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="thumbnail clearfix">
                                    <a style="cursor: pointer;"><img class="img-responsive"
                                            src="/assets/img/img-offer-2.jpg" alt="Image" draggable="false"
                                            oncontextmenu="return false;"></a>

                                    <div class="caption">
                                        <h3><a style="cursor: pointer;">简单易用</a></h3>

                                        <p>前台页面设计简介明了，尽可能地降低了用户的使用难度，同时不失风雅；后台管理栏目进行了科学的分类，助力管理员快速熟悉系统功能并进行系统运维与管理.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- row -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="thumbnail clearfix">
                                    <a style="cursor: pointer;"><img class="img-responsive"
                                            src="/assets/img/img-offer-3.jpg" alt="Image" draggable="false"
                                            oncontextmenu="return false;"></a>

                                    <div class="caption">
                                        <h3><a style="cursor: pointer;">功能强大</a></h3>

                                        <p>集成教学资源管理、计算思维教学辅助与AI帮助、课堂签到等服务于各阶段信息技术学科教学的功能于一体，旨在为广大师生提供更好的教学与学习平台.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="thumbnail clearfix">
                                    <a style="cursor: pointer;"><img class="img-responsive"
                                            src="/assets/img/img-offer-4.jpg" alt="Image" draggable="false"
                                            oncontextmenu="return false;"></a>

                                    <div class="caption">
                                        <h3><a style="cursor: pointer;">高效管理</a></h3>

                                        <p>集中化教学资源分类管理平台，便利教学资源管理与共享；提供课堂签到功能，节省繁琐的考勤流程，提高课堂时间利用率.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- .row -->
                    </div>
                    <!-- .container -->
                </section>

                <section class="testimonial">
                    <section class="section-title">
                        <div class="container text-center">
                            <h2>特色功能展示</h2>
                            <span class="bordered-icon"><i class="fa fa-circle-thin"></i></span>
                        </div>
                    </section>
                    <div class="container">
                        <div id="testimonialSlider" class="carousel slide" data-ride="carousel">

                            <!-- Wrapper for slides -->
                            <div class="carousel-inner" role="listbox">
                                <div class="item active">
                                    <blockquote>
                                        <img src="/assets/img/code&ai2.png" class="use-img" alt=""
                                            style="width: 80%;height: 80%;" />
                                        <br>
                                        <p>在线编译与AI帮助
                                            </br>学生无需安装部署python环境以及IDE即可直接在平台上编写代码、运行代码，
                                            运行完成后还可以向AI提问来解决问题或是对代码进行解读等，
                                            极大提高了课堂学习效率.
                                        </p>

                                    </blockquote>
                                </div>
                                <div class="item">
                                    <blockquote>
                                        <img src="/assets/img/signin.png" class=" img-responsive" alt=""
                                            style="width: 80%;height: 80%;" />
                                        <br>
                                        <p>活动与签到管理
                                            </br>教师通过后台签到管理为学生增添签到任务，考勤时根据后台的学生签到记录处理即可，
                                            以此减少课堂点名的时间，便利课堂管理，提高时间利用率.
                                        </p>

                                    </blockquote>
                                </div>
                                <div class="item">
                                    <blockquote>
                                        <img src="/assets/img/contenglist.png" class="img-responsive" alt=""
                                            style="width: 80%;height: 80%;" />

                                        <p>简单易用的内容中心
                                            </br>内容中心设计较为简介，可用于教学资源展示，在教研与教学时均可为用户提供一定的便利，
                                            同时部署在公网上即可随时随地查看课件，修改课件，为有需要的老师提供工作空间，为有需求的学生提供学习平台
                                            .
                                        </p>
                                    </blockquote>
                                </div>
                            </div>
                            <!-- Controls -->
                            <a class="left carousel-control" href="#testimonialSlider" role="button" data-slide="prev">
                                <span><i class="fa fa-angle-left"></i></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="right carousel-control" href="#testimonialSlider" role="button" data-slide="next">
                                <span><i class="fa fa-angle-right"></i></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                        <!-- #testimonialSlider -->
                    </div>
                </section>
                <!-- .testimonial -->

                <section class="client-logo ptb-100">
                    <section class="section-title">
                        <div class="container text-center">
                            <h2>特别鸣谢</h2>
                            <span class="bordered-icon"><i class="fa fa-circle-thin"></i></span>
                        </div>
                    </section>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-2 col-sm-4 col-xs-6 section-margin">
                                <a target="_blank" href="https://coder.com/docs/code-server/latest"
                                    style="color: black;"><img src="/assets/img/code-server.png" alt="Image">
                                    <center>code-server</center>
                                </a>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-6 section-margin">
                                <a target="_blank" href="https://www.idcsmart.com" style="color: black;"><img
                                        src="/assets/img/idcsmart.png" alt="Image">
                                    <center>智简魔方</center>
                                </a>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-6 section-margin">
                                <a target="_blank" href="https://bt.cn" style="color: black;"><img
                                        src="/assets/img/btpanel.png" alt="Image">
                                    <center>宝塔面板</center>
                                </a>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-6 section-margin">
                                <a target="_blank" href="https://static.kancloud.cn/manual/thinkphp5/"
                                    style="color: black;"><img src="/assets/img/thinkphp.png" alt="Image">
                                    <center>ThinkPHP 5.0</center>
                                </a>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-6 section-margin">
                                <a target="_blank" href="https://www.fastadmin.net/" style="color: black;"><img
                                        src="/assets/img/fastadmin.png" alt="Image">
                                    <center>FASTADMIN</center>
                                </a>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-6 section-margin">
                                <a target="_blank" href="https://xiaozmax.top/" style="color: black;"><img
                                        src="/assets/img/yunzhixinxi.png" alt="Image">
                                    <center>芸志信息|芸志云</center>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!--end of .container -->
                </section>
                <!-- /.client-logo -->


                <footer class="footer">

                    <!-- Footer Widget Section -->
                    <div class="footer-widget-section">
                        <div class="container text-center">
                            <div class="row">
                                <div class="col-sm-4 footer-block">
                                    <div class="footer-widget widget_text">
                                        <div class="footer-logo">
                                            <a href="#"><img src="img/logo.png" alt=""></a>
                                        </div>
                                        <p>目前系统可能还存在一些迷の问题，理论上不会影响整体的使用，如果您在使用中遇到了问题，您可以联系开发者处理，感谢您的理解.
                                            </br>——松原市宁江区芸志信息技术工作室 王志至</p>

                                    </div>
                                </div><!-- /.col-sm-4 -->

                                <div class="col-sm-4 footer-block">
                                    <div class="footer-widget widget_text">
                                        <h3>为极致体验而生</h3>
                                        <p>致力于为师生提供一个简介好用的信息技术学科教育平台，通过教学资源集中化管理便利教师教学与学生学习；接入人工智能大语言模型，辅助学生进行计算思维相关的学习同时培养自学能力，减轻教师负担；集成签到管理，省去繁琐的课堂考勤流程，提高授课效率.
                                        </p>
                                    </div>
                                </div><!-- /.col-sm-4 -->

                                <div class="col-sm-4 footer-block last">
                                    <div class="footer-widget widget_text">
                                        <h3>联系开发者</h3>
                                        <address>
                                            手机 17873304785或19957209814<br>
                                            发送邮件至 <a href="mailto:yunzhixinxi@qq.com">yunzhixinxi@qq.com</a><br>
                                            QQ：2105158013或2308765918<br>
                                        </address>

                                    </div>
                                </div><!-- /.col-sm-4 -->
                            </div>
                        </div>
                    </div><!-- /.Footer Widget Section -->

                    <div class="copyright-section">
                        <div class="container clearfix">
                            <span class="copytext">Copyright &copy; 2024 | <a
                                    title="松原市宁江区芸志信息技术工作室（个体工商户）">芸志信息&王志至</a></span>

                            <!--<ul class="list-inline pull-right">
                                <li class="active"><a href="#">主页</a></li>
                                <li><a href="/index/index/contentlist.html">内容中心</a></li>
                                <li><a href="/index/index/help.html">帮助中心</a></li>
                                <li><a href="/index/index/about.html">关于我们</a></li>
                                <li><a href="/index/user/login.html">登录/注册</a></li>
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
                        <li class="active"><a href="#">主页</a></li>
                        <li><a href="/index/index/contentlist.html">内容中心</a></li>
                        <li><a href="/index/index/help.html">帮助中心</a></li>
                        <li><a href="/index/index/about.html">关于我们</a></li>
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