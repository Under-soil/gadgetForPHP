<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>找回密码</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?php echo $this->config->item('statics_path'); ?>/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo $this->config->item('statics_path'); ?>/font-awesome-4.7.0/css/font-awesome.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo $this->config->item('statics_path'); ?>/adminlte/css/AdminLTE.min.css">
    <link rel="stylesheet" href="<?php echo $this->config->item('statics_path'); ?>/bootstrap-table/bootstrap-table.min.css">
    <link rel="stylesheet" href="<?php echo $this->config->item('statics_path'); ?>/adminlte/css/custom-forms.css">

    <style type="text/css">
        .login-box-body div.form-group{
            margin-left: 0px;
            margin-right: 0px;
        }
        .col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12 {
            position: relative;
            min-height: 1px;
            padding-left: 2px;
            padding-right: 2px;
        }
    </style>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="#"><b><?php echo $this->config->item('app_name').'-找回密码'; ?></b></a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg"></p>
            <form id="form_query" class="bv-form form-horizontal" action="#"  data-toggle="validator" role="form" onsubmit="return false">
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="phone">手&nbsp;&nbsp;&nbsp;机&nbsp;&nbsp;&nbsp;号*</label>
                    <div class="col-sm-9">
                        <input class="form-control" type="text" name="phone" id="phone" placeholder="请输入手机号" maxlength="11">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="captcha">验&nbsp;&nbsp;&nbsp;证&nbsp;&nbsp;&nbsp;码*</label>
                    <div class="col-sm-9">
                        <div style="width: 56%; display: inline-block; position: relative">
                            <input class="form-control" style="width: 100%; display: inline-block" type="text" name="captcha" id="captcha" placeholder="输入验证码" maxlength="4">
                        </div>
                        <img class="captcha" id="captcha_img" src="index.php?/captcha/gen" class="form-control" alt="captcha" onclick='this.src="index.php?/captcha/find_pwd_captcha_img/"+Math.random();'
                             style="cursor: pointer;width: 36%;height: 34px; margin-right: 2%;float: right; position: relative" title="点击切换"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label" for="code">验&nbsp;&nbsp;&nbsp;证&nbsp;&nbsp;&nbsp;码*</label>
                    <div class="col-sm-9">
                        <div style="width: 56%; display: inline-block; position: relative">
                            <input class="form-control" style="width: 100%; display: inline-block" type="text" name="code" id="code" placeholder="输入验证码" maxlength="6">
                        </div>
                        <button id="btn_code" type="button" class="btn btn-primary" style="float: right; padding: 6px 8px;" onclick="get_code()">获取验证码</button>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="password">密　　码*</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" name="password" id="password" placeholder="大小写英文、数字和_#@" maxlength="20">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="repeat_password">重复密码*</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" name="repeat_password" id="repeat_password" placeholder="再次输入密码" maxlength="20">
                    </div>
                </div>
                <div class="row"></div>
                <div class="form-group">
                    <button type="button" id="login" class="btn btn-primary btn-block btn-flat" onclick="set_password()">提 交</button>
                </div>
                <div class="row">
                    <a href="<?php echo base_url('index.php');?>" style="margin-right: 30px;float: right">返回登录</a>
                </div>
            </form>
        </div>
        <!-- /.login-box-body -->
</div>
    <!-- jQuery 3 -->
    <script src="<?php echo $this->config->item('statics_path'); ?>/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->config->item('statics_path'); ?>/other/rsa/jsencrypt.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="<?php echo $this->config->item('statics_path'); ?>/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo $this->config->item('statics_path'); ?>/bootstrapvalidator/js/bootstrapValidator.min.js"></script>
    <script src="<?php echo $this->config->item('statics_path'); ?>/bootstrapvalidator/js/language/zh_CN.js"></script>

    <script type="text/javascript">
        $(function () {
            //验证初始化
            table_validator();
        });

        var countdown = 60;
        
        function set_password() {
            var phone           = $("#phone").val();
            var code            = $("#code").val();
            var password        = $("#password").val();
            var repeat_password = $("#repeat_password").val();

            $("#form_query").bootstrapValidator('validate');//提交验证
            if ($("#form_query").data('bootstrapValidator').isValid()) {
                $.post('index.php?/login/set_password', {'phone': phone, 'code' : code, 'password' : password, 'repeat_password' : repeat_password}, function(data){
                    if (data.r == 4000){
                        alert(data.m);
                        window.location.href = "<?php echo base_url('index.php');?>";
                    }else{
                        alert(data.m);
                    }
                }, "json");
            }
        }

        function get_code() {
            var phone = $("#phone").val();
            var captcha = $("#captcha").val();

            if (is_phone_no(phone)){

                if (/^\d{4}$/.test(captcha))
                {
                    $.post('index.php?/login/send_code', {'phone': phone, 'captcha': captcha}, function(data){
                        if (data.r == 3000)
                        {
                            $('#captcha_img').click();
                        }
                        else if(data.r == 4000)
                        {
                            set_time($("#btn_code"));
                        }
                        alert(data.m);
                    }, "json");
                }
                else
                {
                    $('#captcha_img').click();
                    alert('请输入正确图片二维码')
                }

            }else {
                alert("手机号格式错误");
                $("#phone").focus();
            }
        }

        function is_phone_no(phone) {
            var pattern = /^1[34578]\d{9}$/;
            return pattern.test(phone);
        }

        function set_time(obj) { //发送验证码倒计时
            if (countdown == 0) {
                obj.attr('disabled',false);
                obj.html("获取验证码");
                countdown = 60;
                return;
            } else {
                obj.attr('disabled',true);
                obj.html("重新发送(" + countdown + ")");
                countdown--;
            }
            setTimeout(function() { set_time(obj) } ,1000)
        }

        function table_validator() {
            $("#form_query").bootstrapValidator({
                live: 'enabled',
                excluded: [':disabled', ':hidden', ':not(:visible)'],
                feedbackIcons: {//根据验证结果显示的各种图标
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields:{
                    phone:{
                        validators: {
                            notEmpty: {
                                message: '请输入'
                            },
                            regexp: {//正则验证
                                regexp: /^1[34578]\d{9}$/,
                                message: '手机号格式错误'
                            },
                        }
                    },
                    captcha:{
                        validators: {
                            notEmpty: {
                                message: '请输入'
                            },
                            regexp: {//正则验证
                                regexp: /^\d{4}$/,
                                message: '验证码为4位数字'
                            },
                        }
                    },
                    code:{
                        validators: {
                            notEmpty: {
                                message: '请输入'
                            },
                            regexp: {//正则验证
                                regexp: /^\d{6}$/,
                                message: '验证码为6位数字'
                            },
                        }
                    },
                    password:{
                        validators:{
                            notEmpty: {
                                message: '请输入'
                            },
                            regexp:{
                                regexp:/[\w@#]{6,20}$/,
                                message:'密码仅支持大小写英文，数字，下划线，#号和@，长度为6到20位'
                            },
                            callback: {
                                message: '密码过于简单',
                                callback: function(value, validator) {
                                    $result = 0;
                                    do
                                    {
                                        if ( /[0-9]/.test(value) )
                                        {
                                            $result++;
                                        }
                                        if ( /[a-z]/.test(value) )
                                        {
                                            $result++;
                                        }
                                        if ( /[A-Z]/.test(value) )
                                        {
                                            $result++;
                                        }
                                        if( /[_@#]/.test(value) )
                                        {
                                            $result++;
                                        }
                                    } while (false);
                                    return $result >= 2;
                                }
                            },
                        }
                    },
                    repeat_password:{
                        validators:{
                            notEmpty: {
                                message: '请输入'
                            },
                            identical:{
                                field:'password',
                                message:'密码输入不一致'
                            }
                        }
                    },
                }
            });
        }
    </script>
</body>