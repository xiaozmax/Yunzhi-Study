<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:67:"/www/wwwroot/code/public/../application/admin/view/version/add.html";i:1721720025;s:60:"/www/wwwroot/code/application/admin/view/layout/default.html";i:1689043529;s:57:"/www/wwwroot/code/application/admin/view/common/meta.html";i:1701766692;s:59:"/www/wwwroot/code/application/admin/view/common/script.html";i:1701766507;}*/ ?>
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
                                <style>
    .content {
        padding-bottom:50px;
    }
</style>

<form id="add-form" class="form-horizontal form-ajax" role="form" data-toggle="validator" method="POST" action="">

    <div class="form-group">
        <label for="c-oldversion" class="control-label col-xs-12 col-sm-2"><?php echo __('Oldversion'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-oldversion" class="form-control" name="row[oldversion]" type="text" value="">
        </div>
    </div>
    <div class="form-group">
        <label for="c-newversion" class="control-label col-xs-12 col-sm-2"><?php echo __('Newversion'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-newversion" class="form-control" name="row[newversion]" type="text" value="">
        </div>
    </div>
    <div class="form-group">
        <label for="c-packagesize" class="control-label col-xs-12 col-sm-2"><?php echo __('Packagesize'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-packagesize" class="form-control" name="row[packagesize]" type="text" value="">
        </div>
    </div>
    <div class="form-group">
        <label for="c-content" class="control-label col-xs-12 col-sm-2"><?php echo __('Content'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <textarea id="c-content" class="form-control" name="row[content]"></textarea>
        </div>
    </div>
    <div class="form-group">
        <label for="c-downloadurl" class="control-label col-xs-12 col-sm-2"><?php echo __('Downloadurl'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-downloadurl" class="form-control" name="row[downloadurl]" type="text" value="">
        </div>
    </div>
    <div class="form-group">
        <label for="c-enforce" class="control-label col-xs-12 col-sm-2"><?php echo __('Enforce'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <?php echo build_radios('row[enforce]', [1=>__('Yes'), 0=>__('No')], 1); ?>
        </div>
    </div>
    <div class="form-group">
        <label for="c-weigh" class="control-label col-xs-12 col-sm-2"><?php echo __('Weigh'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-weigh" class="form-control" name="row[weigh]" type="number" value="0">
        </div>
    </div>
    <div class="form-group">
        <label for="c-status" class="control-label col-xs-12 col-sm-2"><?php echo __('Status'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <?php echo build_radios('row[status]', ['normal'=>__('Normal'), 'hidden'=>__('Hidden')]); ?>
        </div>
    </div>
    <div class="form-group layer-footer">
        <label class="control-label col-xs-12 col-sm-2"></label>
        <div class="col-xs-12 col-sm-8">
            <button type="submit" class="btn btn-success btn-embossed disabled"><?php echo __('OK'); ?></button>
            <button type="reset" class="btn btn-default btn-embossed"><?php echo __('Reset'); ?></button>
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
