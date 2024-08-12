<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:77:"/www/wwwroot/code/public/../application/admin/view/xunsearch/project/add.html";i:1721738288;s:60:"/www/wwwroot/code/application/admin/view/layout/default.html";i:1689043529;s:57:"/www/wwwroot/code/application/admin/view/common/meta.html";i:1701766692;s:59:"/www/wwwroot/code/application/admin/view/common/script.html";i:1701766507;}*/ ?>
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
                                <form id="add-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="">

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Name'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-name" class="form-control" name="row[name]" data-rule="required;username;name" type="text">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Title'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-title" class="form-control" name="row[title]" data-rule="required" type="text">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Charset'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-charset" class="form-control" name="row[charset]" type="text" readonly value="UTF-8">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Serverindex'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-serverindex" class="form-control" name="row[serverindex]" type="text" value="8383">
            <div class="alert alert-danger-light" style="margin-top:5px;">
                端口号(数字)，连接 localhost 的该端口号 (例：8383)<br>
                地址:端口号，冒号连接地址（域名、IP地址）和端口 (例：127.0.0.1:8383)<br>
                文件路径，本机的 unix socket 连接路径 (例：/tmp/index.sock)
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Serversearch'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-serversearch" class="form-control" name="row[serversearch]" type="text" value="8384">
            <div class="alert alert-danger-light" style="margin-top:5px;">
                端口号(数字)，连接 localhost 的该端口号 (例：8384)<br>
                地址:端口号，冒号连接地址（域名、IP地址）和端口 (例：127.0.0.1:8384)<br>
                文件路径，本机的 unix socket 连接路径 (例：/tmp/search.sock)
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Logo'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <div class="input-group">
                <input id="c-logo" class="form-control" size="50" name="row[logo]" type="text" value="" placeholder="留空将使用默认Logo，建议至少100px*100px">
                <div class="input-group-addon no-border no-padding">
                    <span><button type="button" id="plupload-image" class="btn btn-danger plupload" data-input-id="c-logo" data-mimetype="image/gif,image/jpeg,image/png,image/jpg,image/bmp,image/webp" data-multiple="false" data-preview-id="p-logo"><i class="fa fa-upload"></i> <?php echo __('Upload'); ?></button></span>
                    <span><button type="button" id="fachoose-image" class="btn btn-primary fachoose" data-input-id="c-logo" data-mimetype="image/*" data-multiple="false"><i class="fa fa-list"></i> <?php echo __('Choose'); ?></button></span>
                </div>
                <span class="msg-box n-right" for="c-logo"></span>
            </div>
            <ul class="row list-inline plupload-preview" id="p-logo"></ul>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Indextpl'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-indextpl" class="form-control" name="row[indextpl]" type="text" value="index" placeholder="留空将使用默认模板">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Listtpl'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-listtpl" class="form-control" name="row[listtpl]" type="text" value="list" placeholder="留空将使用默认模板">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Pagesize'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-pagesize" class="form-control" name="row[pagesize]" type="number" value="10">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Isfrontend'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input  id="c-isfrontend" name="row[isfrontend]" type="hidden" value="1">
            <a href="javascript:;" data-toggle="switcher" class="btn-switcher" data-input-id="c-isfrontend" data-yes="1" data-no="0" >
                <i class="fa fa-toggle-on text-success fa-2x"></i>
            </a>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Isfuzzy'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input  id="c-isfuzzy" name="row[isfuzzy]" type="hidden" value="1">
            <a href="javascript:;" data-toggle="switcher" class="btn-switcher" data-input-id="c-isfuzzy" data-yes="1" data-no="0" >
                <i class="fa fa-toggle-on text-success fa-2x"></i>
            </a>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Issynonyms'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input  id="c-issynonyms" name="row[issynonyms]" type="hidden" value="1">
            <a href="javascript:;" data-toggle="switcher" class="btn-switcher" data-input-id="c-issynonyms" data-yes="1" data-no="0" >
                <i class="fa fa-toggle-on text-success fa-2x"></i>
            </a>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Isindexhotwords'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input  id="c-isindexhotwords" name="row[isindexhotwords]" type="hidden" value="1">
            <a href="javascript:;" data-toggle="switcher" class="btn-switcher" data-input-id="c-isindexhotwords" data-yes="1" data-no="0" >
                <i class="fa fa-toggle-on text-success fa-2x"></i>
            </a>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Ishotwords'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input  id="c-ishotwords" name="row[ishotwords]" type="hidden" value="0">
            <a href="javascript:;" data-toggle="switcher" class="btn-switcher" data-input-id="c-ishotwords" data-yes="1" data-no="0" >
                <i class="fa fa-toggle-on text-success fa-flip-horizontal text-gray fa-2x"></i>
            </a>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Isrelatedwords'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input  id="c-isrelatedwords" name="row[isrelatedwords]" type="hidden" value="">
            <a href="javascript:;" data-toggle="switcher" class="btn-switcher" data-input-id="c-isrelatedwords" data-yes="1" data-no="0" >
                <i class="fa fa-toggle-on text-success fa-2x"></i>
            </a>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Status'); ?>:</label>
        <div class="col-xs-12 col-sm-8">

            <div class="radio">
            <?php if(is_array($statusList) || $statusList instanceof \think\Collection || $statusList instanceof \think\Paginator): if( count($statusList)==0 ) : echo "" ;else: foreach($statusList as $key=>$vo): ?>
            <label for="row[status]-<?php echo $key; ?>"><input id="row[status]-<?php echo $key; ?>" name="row[status]" type="radio" value="<?php echo $key; ?>" <?php if(in_array(($key), explode(',',"normal"))): ?>checked<?php endif; ?> /> <?php echo $vo; ?></label>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            </div>

        </div>
    </div>
    <div class="form-group layer-footer">
        <label class="control-label col-xs-12 col-sm-2"></label>
        <div class="col-xs-12 col-sm-8">
            <button type="submit" class="btn btn-primary btn-embossed disabled"><?php echo __('OK'); ?></button>
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
