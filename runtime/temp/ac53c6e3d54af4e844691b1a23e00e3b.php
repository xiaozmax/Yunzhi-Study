<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:71:"/www/wwwroot/code/public/../application/admin/view/taskrecord/edit.html";i:1721669441;s:60:"/www/wwwroot/code/application/admin/view/layout/default.html";i:1689043529;s:57:"/www/wwwroot/code/application/admin/view/common/meta.html";i:1701766692;s:59:"/www/wwwroot/code/application/admin/view/common/script.html";i:1701766507;}*/ ?>
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
        <label class="control-label col-xs-12 col-sm-2"><!--<?php echo __('Taskid'); ?>:-->编译ID</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-taskid" data-rule="required" class="form-control" name="row[taskid]" type="number" value="<?php echo htmlentities($row['taskid'] ?? ''); ?>" style="cursor: default;" disabled>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Code'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <textarea id="c-code" data-rule="required" class="form-control " rows="5" name="row[code]" cols="50" disabled style="cursor: default;"><?php echo htmlentities($row['code'] ?? ''); ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Output'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <textarea id="c-output" data-rule="required" class="form-control " rows="5" name="row[output]" cols="50" style="cursor: default;" disabled><?php echo htmlentities($row['output'] ?? ''); ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Ai'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <textarea id="c-ai" data-rule="required" class="form-control " rows="5" name="row[ai]" cols="50" style="cursor: default;" disabled><?php echo htmlentities($row['ai'] ?? ''); ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Teacher'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-teacher" class="form-control" name="row[teacher]" type="number" value="<?php echo htmlentities($row['teacher'] ?? ''); ?>" style="cursor: default;" disabled>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Lang'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <textarea id="c-lang" data-rule="required" class="form-control " rows="5" name="row[lang]" cols="50" style="cursor: default;" disabled><?php echo htmlentities($row['lang'] ?? ''); ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Subtime'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-subtime" data-rule="required" class="form-control datetimepicker" data-date-format="YYYY-MM-DD HH:mm:ss" data-use-current="true" name="row[subtime]" type="text" value="<?php echo $row['subtime']?datetime($row['subtime']):''; ?>" style="cursor: default;" disabled>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Uid'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-uid" data-rule="required" class="form-control" name="row[uid]" type="number" value="<?php echo htmlentities($row['uid'] ?? ''); ?>" style="cursor: default;" disabled>
        </div>
    </div>
    <!--div class="form-group layer-footer">
        <label class="control-label col-xs-12 col-sm-2"></label>
        <div class="col-xs-12 col-sm-8">
            <button type="submit" class="btn btn-primary btn-embossed disabled"><?php echo __('OK'); ?></button>
        </div>
    </div-->
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