<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en"><head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta charset="utf-8">
    <title>登录页面 - 推广员后台</title>

    <meta name="description" content="User login page">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <!-- bootstrap & fontawesome -->
    <link rel="stylesheet" href="<?php echo $this->config->item('statics_path'); ?>/aceadmin/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $this->config->item('statics_path'); ?>/font-awesome-4.7.0/css/font-awesome.min.css">

    <!-- ace styles -->
    <link rel="stylesheet" href="<?php echo $this->config->item('statics_path'); ?>/aceadmin/css/ace.min.css">

    <link rel="stylesheet" href="<?php echo $this->config->item('statics_path'); ?>/aceadmin/css/ace-rtl.min.css">
    <style>
        @media print {#ghostery-purple-box {display:none !important}}
        .light-login{
            background-color: #DFE0E2;
        }
        .login-layout .widget-box
        {
            background-color: rgba(100,110,120,.4);
        }
        .center h1{font-size: 2em}
    </style>
</head>

<body class="login-layout light-login">
<div class="main-container">
    <div class="main-content">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <div class="login-container">
                    <div class="center">
                        <h1>
                            <i class="ace-icon fa fa-leaf green"></i>
                            <span class="red"><?php echo $this->config->item('app_name'); ?></span>
                            <span class="grey" id="id-text2">推广员管理系统</span>
                        </h1>
                        <h4 class="blue" id="id-company-text"></h4>
                    </div>

                    <div class="space-6"></div>

                    <div class="position-relative">
                        <div id="login-box" class="login-box visible widget-box no-border">
                            <div class="widget-body">
                                <div class="widget-main">
                                    <h4 class="header blue lighter bigger">
                                        <i class="ace-icon fa fa-coffee green"></i>请输入您的信息
                                    </h4>

                                    <div class="space-6"></div>
                                    <input id="pk" value="<?php echo $pu_key;?>" type="hidden">
                                    <form class="layui-form">
                                        <fieldset>
                                            <label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="text" class="form-control" name="username" id="username" lay-verify="username" placeholder="用户名">
														</span>
                                            </label>

                                            <label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" class="form-control" id="password" name="password" lay-verify="passwd" placeholder="密码">
														</span>
                                            </label>

                                            <label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="text" class="form-control"   name="captcha" id="captcha" onclick='this.src="index.php?/captcha/gen/"+Math.random();' placeholder="验证码" lay-verify="captcha" maxlength="4" autocomplete="off" />
														</span>
                                            </label>
                                            <label class="block clearfix">
														<span class="block input-icon input-icon-right">
                                                            <img class="captcha" src="index.php?/captcha/gen" alt="captche" onclick='this.src="index.php?/captcha/gen/"+Math.random();' style="cursor: pointer;width: 100%;" title="点击切换"/>
														</span>
                                            </label>

                                            <div class="space"></div>

                                            <div class="clearfix">

                                                <button type="submit" lay-submit="" lay-filter="login"  class="width-35 pull-right btn btn-sm btn-primary">
                                                    <i class="ace-icon fa fa-key"></i>
                                                    <span class="bigger-110">登录</span>
                                                </button>
                                            </div>

                                            <div class="space-4"></div>
                                        </fieldset>
                                    </form>
                                </div><!-- /.widget-main -->
                            </div><!-- /.widget-body -->
                        </div><!-- /.login-box -->
                    </div><!-- /.position-relative -->

                </div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.main-content -->
</div><!-- /.main-container -->



<script src="<?php echo $this->config->item('statics_path'); ?>/aceadmin/js/jquery-1.11.3.min.js"></script>
<script src="<?php echo $this->config->item('statics_path'); ?>/other/jquery-1.8.2.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item('statics_path'); ?>/layui/layui.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item('statics_path'); ?>/other/rsa/jsencrypt.js"></script>

<script type="text/javascript">
    if('ontouchstart' in document.documentElement) document.write("<script src='<?php echo $this->config->item('statics_path'); ?>/aceadmin/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
</script>

<!--login.js 登录页面的表单验证和监听提交-->
<script src="<?php echo $this->config->item('statics_path'); ?>/other/js/public/login.js"></script>

</body><div></div></html>
