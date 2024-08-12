<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:77:"/www/wwwroot/code/public/../application/index/view/index/contentlist_new.html";i:1721881350;}*/ ?>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link href="/asstes/css/bootstrap.min.css" rel="stylesheet">

    <!--<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/v4-shims.css">
    <script defer src="https://use.fontawesome.com/releases/v5.11.2/js/all.js"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.11.2/js/v4-shims.js"></script>-->
    <link rel="stylesheet"
        href="https://lf3-cdn-tos.bytecdntp.com/cdn/expire-1-M/font-awesome/4.7.0/css/font-awesome.min.css">
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
                                <li><a href="index.html">主页</a></li>
                                <li class="active"><a href="#">内容中心</a></li>
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
                <div class="single-page-title" onselectstart="return false" style="cursor: pointer;">
                    <div class="container text-center">
                        <h2>内容中心</h2>
                    </div>

                </div>
                <div style="background-color: rgb(241, 241, 241); width: 100%; min-height: 80vh;background-size: contain;
                background-repeat:repeat-y;
                background-size: 100%;
                float: inline-start;position: relative;"><!--background-image: url('/assets/img/background.png');-->
                    <!-- 在您的 HTML 中添加一个容器 -->
                    <!-- 修改后的 HTML 代码 -->
                    <!-- 修改后的 HTML 代码 -->

                    <div class="category-bag">
                        <center>
                            <h1>文章分类</h1>
                        </center>
                        <div id="category-container" class="fcontainer"></div>
                    </div>
                    <div id="article-container" class="article-container"></div>

                </div>
                <div style="background-color: rgb(241, 241, 241);width: 100%; min-height: 1vh;background-size: contain;
                background-repeat:repeat-y;
                background-size: 100%;
                float: inline-start;"><!--background-image: url('/assets/img/background.png'); -->
                    <button id="load-more-button" class="btn btn-primary" style="position: absolute;
                bottom: 1em;position:static;margin-left: 30%;border-radius: 10px;">加载更多</button>
                </div>
                <footer class="footer">
                    <div class="copyright-section">
                        <div class="container clearfix">
                            <span class="copytext">Copyright &copy; 2024 | <a
                                    title="松原市宁江区芸志信息技术工作室（个体工商户）">芸志信息</a></span>

                            <!--<ul class="list-inline pull-right">
                                <li><a href="/index.html">主页</a></li>
                                <li class="active"><a href="#">内容中心</a></li>
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
                        <li class="active"><a href="#">内容中心</a></li>
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
    <div>

    </div>
    <script>
        $(document).ready(function () {
            var pageNow = 1; // 当前页码
            var pageSize = 10; // 每页显示数量
            var articles = []; // 文章列表
            var categoryId = 0; // 分类ID
            var maxPage = 10000; // 最大页码，需要根据后端返回的数据进行更新

            // 发送GET请求获取分类列表
            $.get('/index/index/get_category', function (data) {
                // 假设返回的数据是一个分类数组
                var categories = data; // 假定数据结构为 [{...}, {...}, ...]
                var container = $('#category-container'); // 假定有一个ID为category-container的元素来存放分类按钮
                var allCategories = {
                    id: 0,
                    name: '全部分类'
                };
                categories.unshift(allCategories); // 将全部分类添加到数组开头
                // 显示所有分类
                categories.forEach(function (category) {
                    var button = $('<button class="btn btn-category btn-default">' + category.name + '</button>');
                    button.click(function () {
                        // 处理分类点击事件，传递 category_id 参数
                        categoryId = category.id;
                        // 设置点击的按钮文字为蓝色，其他按钮文字为黑色
                        $(this).css('color', 'blue').siblings().css('color', 'black');
                        // 清空文章列表并重新获取
                        articles = [];
                        pageNow = 1; // 重置页码
                        maxPage = 10000; // 重置最大页码
                        getMoreArticles();
                    });
                    container.append(button);
                });

                // 默认选中全部分类按钮
                $('#all-categories').click(function () {
                    categoryId = 0;
                    // 清空文章列表并重新获取
                    articles = [];
                    pageNow = 1; // 重置页码
                    maxPage = 10000; // 重置最大页码
                    getMoreArticles();
                });
                limitText();
            })
                .fail(function (jqXHR, textStatus, errorThrown) {
                    console.error('AJAX请求失败: ' + textStatus + ', ' + errorThrown);
                });

            // 初始获取文章列表
            getMoreArticles();
            var btnl = document.getElementById("load-more-button");
            btnl.onclick = function () {
                if (pageNow < maxPage) {
                    pageNow++; // 页码增加
                    getMoreArticles(); // 获取更多文章
                }
            }
            // 添加一个按钮来触发加载更多
            $('load-more-button').click(function () {
                if (pageNow < maxPage) {
                    pageNow++; // 页码增加
                    getMoreArticles(); // 获取更多文章
                    limitText();
                }
            });
            // 获取更多文章的函数
            function getMoreArticles() {
                $.post('/index/index/contentlist', {
                    category: categoryId,
                    size: pageSize,
                    pagenow: pageNow
                }, function (data) {
                    if (data.data.length > 0) {
                        document.getElementById("load-more-button").style.visibility = "visible";
                        // 添加新文章到文章列表
                        articles = articles.concat(data.data); // 使用concat避免修改原始数组
                        // 更新文章列表
                        $('#article-container').html(createArticleList(articles));
                        // 如果返回的数据不满一页，说明已经没有更多文章了
                        if (data.data.length < pageSize) {
                            maxPage = pageNow; // 设置最大页码为当前页码
                            $('#article-container').append('<p>没有更多文章了。</p>');
                            document.getElementById("load-more-button").style.visibility = "hidden";
                        }
                    } else {
                        // 如果没有更多文章，显示提示信息
                        if (pageNow === 1) {
                            $('#article-container').html('<p>没有文章可供显示。</p>');
                            document.getElementById("load-more-button").style.visibility = "hidden";
                        } else {
                            $('#article-container').append('<p>没有更多文章了。</p>');
                            document.getElementById("load-more-button").style.visibility = "hidden";
                        }
                        maxPage = pageNow; // 设置最大页码为当前页码
                    }
                    limitText();
                })
                    .fail(function (jqXHR, textStatus, errorThrown) {
                        console.error('AJAX请求失败: ' + textStatus + ', ' + errorThrown);
                    });
            }

            // 创建文章列表的函数
            // 创建文章列表的函数
function createArticleList(articleList) {
    var list = '';
    articleList.forEach(function (article) {
        // 移除内容中的 <img> 标签
        var contentWithoutImages = article.content.replace(/<img[^>]*>/g, '');
        
        // 构建文章列表项
        list += '<div class="article-item">' + 
                "<a href='/index/index/content?id=" + Number(article.article_id) + "'>" + 
                article.title + 
                "</a>" + 
                '<br>' + 
                '<p1>' + 
                contentWithoutImages + 
                '</p1>' + 
                '</br><p2 style="font-size:20px;"><i class="fa fa-hand-pointer-o" aria-hidden="true" style="margin-bottom:0px;font-size:20px;"/></i>' + 
                article.showedtimes + 
                '</p2>' + 
                '</div>';
    });
    return list;
}

            function limitText() {
                var paragraphs = document.querySelectorAll('.article-item p1');
                paragraphs.forEach(function (p) {
                    //删除img标签
                    var images = p.querySelectorAll('img');
                    images.forEach(function (img) {
                        img.remove();
                    });
                    // 递归提取所有文本内容
                    function extractText(element) {
                        var text = '';
                        for (var child = element.firstChild; child; child = child.nextSibling) {
                            if (child.nodeType === Node.TEXT_NODE) {
                                text += child.textContent;
                            } else if (child.nodeType === Node.ELEMENT_NODE) {
                                text += extractText(child);
                            }
                        }
                        return text;
                    }

                    var fullText = extractText(p);
                    var maxLength = 80; // 假设这里限制为100个字符
                    if (fullText.length > maxLength) {
                        // 截断文本并添加省略号
                        p.textContent = fullText.substring(0, maxLength) + '...';
                    } else {
                        // 如果文本没有超出限制，则保持原有内容
                        p.textContent = fullText;
                    }
                });
            }

            // 在文档加载完成后调用函数
            document.addEventListener('DOMContentLoaded', limitText);


        });


    </script>
    <script>


    </script>
</body>

</html>