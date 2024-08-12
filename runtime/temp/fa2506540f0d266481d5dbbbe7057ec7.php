<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:72:"/www/wwwroot/code/public/../application/admin/view/questioning/edit.html";i:1721702957;s:60:"/www/wwwroot/code/application/admin/view/layout/default.html";i:1689043529;s:57:"/www/wwwroot/code/application/admin/view/common/meta.html";i:1701766692;s:59:"/www/wwwroot/code/application/admin/view/common/script.html";i:1701766507;}*/ ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
<title><?php echo (isset($title) && ($title !== '')?$title:''); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta name="renderer" content="webkit">
<meta name="referrer" content="never">
<meta name="robots" content="noindex, nofollow">

<link rel="shortcut icon" href="/assets/img/favicon.ico" />
<!-- Loading Bootstrap -->
<link href="/assets/css/backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.css?v=<?php echo \think\Config::get('site.version'); ?>" rel="stylesheet">

<?php if(\think\Config::get('fastadmin.adminskin')): ?>
<link href="/assets/css/skins/<?php echo \think\Config::get('fastadmin.adminskin'); ?>.css?v=<?php echo \think\Config::get('site.version'); ?>" rel="stylesheet">
<?php endif; ?>

<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
<!--[if lt IE 9]>
  <script src="/assets/js/html5shiv.js"></script>
  <script src="/assets/js/respond.min.js"></script>
<![endif]-->
<script type="text/javascript">
    var require = {
        config:  <?php echo json_encode($config ?? ''); ?>
    };
</script>
    </head>

    <body class="inside-header inside-aside <?php echo defined('IS_DIALOG') && IS_DIALOG ? 'is-dialog' : ''; ?>">
        <div id="main" role="main">
            <div class="tab-content tab-addtabs">
                <div id="content">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <section class="content-header hide">
                                <h1>
                                    <?php echo __('Dashboard'); ?>
                                    <small><?php echo __('Control panel'); ?></small>
                                </h1>
                            </section>
                            <?php if(!IS_DIALOG && !\think\Config::get('fastadmin.multiplenav') && \think\Config::get('fastadmin.breadcrumb')): ?>
                            <!-- RIBBON -->
                            <div id="ribbon">
                                <ol class="breadcrumb pull-left">
                                    <?php if($auth->check('dashboard')): ?>
                                    <li><a href="dashboard" class="addtabsit"><i class="fa fa-dashboard"></i> <?php echo __('Dashboard'); ?></a></li>
                                    <?php endif; ?>
                                </ol>
                                <ol class="breadcrumb pull-right">
                                    <?php foreach($breadcrumb as $vo): ?>
                                    <li><a href="javascript:;" data-url="<?php echo $vo['url']; ?>"><?php echo $vo['title']; ?></a></li>
                                    <?php endforeach; ?>
                                </ol>
                            </div>
                            <!-- END RIBBON -->
                            <?php endif; ?>
                            <div class="content">
                                <form id="edit-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="">

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Uid'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-uid" data-rule="required" class="form-control" name="row[uid]" type="number"
                value="<?php echo htmlentities($row['uid'] ?? ''); ?>" style="cursor: default;" disabled>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Content'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <textarea id="c-content" data-rule="required" class="form-control" rows="5" name="row[content]"
                cols="50" style="width: 100%;height: 30vh;cursor: default;" disabled><?php echo htmlentities($row['content'] ?? ''); ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2">提问代码内容</label>
        <div class="col-xs-12 col-sm-8">
            <textarea id="c-code" data-rule="required" class="form-control" rows="5" name="record[code]" cols="50"
                style="height:30vh;font-size: medium;cursor: default;" disabled><?php echo htmlentities($record['code'] ?? ''); ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2">代码运行结果</label>
        <div class="col-xs-12 col-sm-8">
            <textarea id="c-output" data-rule="required" class="form-control" rows="5" name="record[output]" cols="50"
                style="height:30vh;font-size: medium;cursor: default;" disabled><?php echo htmlentities($record['output'] ?? ''); ?></textarea>
        </div>
    </div>
    <!-- 在视图中显示studytask的title、content和ans -->
    <?php if (!empty($studyTask)): ?>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2">学习任务标题:</label>
        <div class="col-xs-12 col-sm-8">
            <input type="text" class="form-control" readonly value="<?php echo $studyTask['title']; ?>" style="cursor: default;" disabled />
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2">学习任务内容:</label>
        <div class="col-xs-12 col-sm-8">
            <!-- 使用一个隐藏的textarea来存储转义后的HTML内容 -->
            <textarea id="studytask-content" class="form-control" readonly
                style="display:none;"><?php echo htmlspecialchars($studyTask['content']); ?></textarea>
            <!-- 创建一个div来展示实际的HTML内容，并添加边框样式 -->
            <div id="studytask-content-html" style="border: 1px solid #ccc; padding: 10px; margin-top: 5px;"></div>
        </div>
    </div>

    <script>
        // 页面加载完毕后，将textarea中的内容设置为div的HTML
        document.addEventListener('DOMContentLoaded', function () {
            var studyTaskContent = document.getElementById('studytask-content').value;
            document.getElementById('studytask-content-html').innerHTML = studyTaskContent;
        });
    </script>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2">学习任务答案:</label>
        <div class="col-xs-12 col-sm-8">
            <input type="text" class="form-control" readonly value="<?php echo $studyTask['ans']; ?>" />
        </div>
    </div>
    <?php else: ?>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2">学习任务信息:</label>
        <div class="col-xs-12 col-sm-8">
            <p>没有找到对应的学习任务信息。</p>
        </div>
    </div>
    <?php endif; ?>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Reply_content'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <textarea id="c-reply_content" class="form-control editor" rows="5" name="row[reply_content]"
                cols="50"><?php echo htmlentities($row['reply_content'] ?? ''); ?></textarea>
        </div>
    </div>
    <div class="form-group layer-footer">
        <label class="control-label col-xs-12 col-sm-2"></label>
        <div class="col-xs-12 col-sm-8">
            <button type="submit" class="btn btn-primary btn-embossed disabled"><?php echo __('OK'); ?></button>
        </div>
    </div>
</form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo htmlentities($site['version'] ?? ''); ?>"></script>

    </body>
</html>
