<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:69:"/www/wwwroot/code/public/../application/index/view/user/register.html";i:1721740443;s:60:"/www/wwwroot/code/application/index/view/layout/default.html";i:1689043529;s:57:"/www/wwwroot/code/application/index/view/common/meta.html";i:1710566795;s:60:"/www/wwwroot/code/application/index/view/common/captcha.html";i:1689043529;s:59:"/www/wwwroot/code/application/index/view/common/script.html";i:1710516990;}*/ ?>
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
            <div id="content-container" class="container">
    <div class="user-section login-section">
        <div class="logon-tab clearfix"><a href="<?php echo url('user/login'); ?>?url=<?php echo htmlentities(urlencode($url ?? '') ?? ''); ?>"><?php echo __('Sign in'); ?></a> <a class="active"><?php echo __('Sign up'); ?></a></div>
        <div class="login-main">
            <form name="form1" id="register-form" class="form-vertical" method="POST" action="">
                <!--@IndexRegisterFormBegin-->
                <input type="hidden" name="invite_user_id" value="0"/>
                <input type="hidden" name="url" value="<?php echo htmlentities($url ?? ''); ?>"/>
                <?php echo token(); ?>
                <div class="form-group">
                    <label class="control-label required"><?php echo __('Email'); ?><span class="text-success"></span></label>
                    <div class="controls">
                        <input type="text" name="email" id="email" data-rule="required;email" class="form-control" placeholder="<?php echo __('Email'); ?>">
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo __('Username'); ?></label>
                    <div class="controls">
                        <input type="text" id="username" name="username" data-rule="required;username" class="form-control" placeholder="<?php echo __('Username must be 3 to 30 characters'); ?>">
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo __('Password'); ?></label>
                    <div class="controls">
                        <input type="password" id="password" name="password" data-rule="required;password" class="form-control" placeholder="<?php echo __('Password must be 6 to 30 characters'); ?>">
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo __('Authcode'); ?></label>
                    <div class="controls">
                        <input type="text" id="authcode" name="authcode" data-rule="required;authcode" class="form-control" placeholder="<?php echo __('Please input the authcode from your teacher'); ?>">
                        <p class="help-block"></p>
                    </div>
                </div>

                <!--@CaptchaBegin-->
                <?php if($captchaType): ?>
                <div class="form-group">
                    <!--<label class="control-label"><?php echo __('Captcha'); ?></label>-->
                    <div class="controls">
                        <div class="input-group">
                            <!--@formatter:off-->
<?php if("false" == 'email'): ?>
    <input type="text" name="captcha" class="form-control" data-rule="required;length(<?php echo \think\Config::get('captcha.length'); ?>);digits;remote(<?php echo url('api/validate/check_ems_correct'); ?>, event=register, email:#email)" />
    <span class="input-group-btn" style="padding:0;border:none;">
        <a href="javascript:;" class="btn btn-info btn-captcha" data-url="<?php echo url('api/ems/send'); ?>" data-type="email" data-event="register">发送验证码</a>
    </span>
<?php elseif("false" == 'mobile'): ?>
    <input type="text" name="captcha" class="form-control" data-rule="required;length(<?php echo \think\Config::get('captcha.length'); ?>);digits;remote(<?php echo url('api/validate/check_sms_correct'); ?>, event=register, mobile:#mobile)" />
    <span class="input-group-btn" style="padding:0;border:none;">
        <a href="javascript:;" class="btn btn-info btn-captcha" data-url="<?php echo url('api/sms/send'); ?>" data-type="mobile" data-event="register">发送验证码</a>
    </span>
<?php elseif("false" == 'wechat'): if(get_addon_info('wechat')): ?>
        <input type="text" name="captcha" class="form-control" data-rule="required;length(<?php echo \think\Config::get('captcha.length'); ?>);remote(<?php echo addon_url('wechat/captcha/check'); ?>, event=register)" />
        <span class="input-group-btn" style="padding:0;border:none;">
            <a href="javascript:;" class="btn btn-info btn-captcha" data-url="<?php echo addon_url('wechat/captcha/send'); ?>" data-type="wechat" data-event="register">获取验证码</a>
        </span>
    <?php else: ?>
        请在后台插件管理中安装《微信管理插件》
    <?php endif; elseif("false" == 'text'): ?>
    <input type="text" name="captcha" class="form-control" data-rule="required;length(<?php echo \think\Config::get('captcha.length'); ?>)" />
    <span class="input-group-btn" style="padding:0;border:none;">
        <img src="<?php echo captcha_src(); ?>" width="100" height="32" onclick="this.src = '<?php echo captcha_src(); ?>?r=' + Math.random();"/>
    </span>
<?php endif; ?>
<!--@formatter:on-->

                        </div>
                        <p class="help-block"></p>
                    </div>
                </div>
                <?php endif; ?>
                <!--@CaptchaEnd-->

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block"><?php echo __('Sign up'); ?></button>
                    <a href="<?php echo url('user/login'); ?>?url=<?php echo htmlentities(urlencode($url ?? '') ?? ''); ?>" class="btn btn-default btn-lg btn-block mt-3 no-border"><?php echo __('Already have an account? Sign in'); ?></a>
                </div>
                <!--@IndexRegisterFormEnd-->
            </form>
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
