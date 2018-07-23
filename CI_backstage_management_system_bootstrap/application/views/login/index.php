<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>登录页面</title>
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

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <style>
        .tab_li{
            width: 28%;
            text-align: center;
        }
    </style>
</head>
<body class="hold-transition login-page">

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                </h4>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<div class="login-box">
    <div class="login-logo">
        <a href="#"><b><?php echo $this->config->item('app_name'); ?></b></a>
    </div>

    <ul id="myTab" class="nav nav-tabs">
        <li class="active tab_li"><a href="#div_agent" data-toggle="tab">推广员</a></li>
        <li class="tab_li"><a href="#div_manager" data-toggle="tab">管理员</a></li>
    </ul>

    <div id="myTabContent" class="tab-content">
        <!-- /.login-logo -->
        <div class="login-box-body tab-pane fade in active" id="div_agent">
            <p class="login-box-msg"></p>
            <input id="pk" value="<?php echo $pu_key;?>" type="hidden">
            <form action="#"  data-toggle="validator" role="form" onsubmit="return false" id="a_form">
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" name="a_username" id="a_username" placeholder="用户名" pattern='^[0-9a-zA-Z\u4e00-\u9fa5][0-9a-zA-Z_@.\u4e00-\u9fa5]{0,18}[0-9a-zA-Z\u4e00-\u9fa5]$' required>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" name="a_password" id="a_password" placeholder="密码" pattern='^[\w@#]{6,20}$' required data-bv-message="请输入正确密码" maxlength="20">
                </div>
                <div class="form-group has-feedback">
                    <div class="input-group" style="width: 100%">
                        <input type="text" class="form-control col-md-6"  style="width: 49%" name="a_captcha" id="a_captcha"  placeholder="图形验证码" pattern="^[0-9]{4}$" required maxlength="4" data-bv-message="请输入正确验证码">
                        <img class="captcha" id="a_captcha_img" src="index.php?/captcha/gen" class="col-md-6 form-control" alt="captche" onclick='this.src="index.php?/captcha/gen/"+Math.random();' style="cursor: pointer;width: 49%;height: 100%" title="点击切换"/>
                    </div>
                </div>
                <div class="row"></div>
                <div class="form-group">
                    <button type="button" id="a_login" class="btn btn-primary btn-block btn-flat">登 录</button>
                </div>
                <div class="row">
                    <a href="<?php echo base_url('index.php?/login/password_find');?>" style="margin-right: 30px;float: right">忘记密码</a>
                </div>
            </form>

        </div>
        <!-- /.login-box-body -->

        <div class="login-box-body tab-pane fade" id="div_manager">
        <p class="login-box-msg"></p>
        <input id="pk" value="<?php echo $pu_key;?>" type="hidden">
        <form action="#"  data-toggle="validator" role="form" onsubmit="return false" id="m_form">
            <div class="form-group has-feedback">
                <input type="text" class="form-control" id="m_username" name="m_username" placeholder="请输入手机号" pattern="^[\d]{11}$" required maxlength="11">
            </div>
            <div class="form-group has-feedback">
                <div class="input-group" style="width: 100%">
                    <input type="text" class="form-control col-md-6"  style="width: 59%" name="m_captcha" id="m_captcha"  placeholder="图形验证码" pattern="^[0-9]{4}$" required maxlength="4" data-bv-message="请输入正确验证码">
                    <img id="m_captcha_img" class="captcha" src="<?php echo base_url();?>index.php?/captcha/manager_login" class="col-md-6 form-control" alt="captche"
                         onclick='this.src="<?php echo base_url();?>index.php?/captcha/manager_login/"+Math.random();' style="cursor: pointer;width: 39%;height: 100%" title="点击切换"/>
                </div>
            </div>
            <div class="form-group has-feedback">
                <div style="width: 59%; display: inline-block; position: relative">
                    <input class="form-control" style="width: 100%; display: inline-block" type="text" name="m_code" id="m_code" placeholder="手机验证码" maxlength="6" pattern="^[0-9]{6}$" required data-bv-message="请输入正确验证码">
                </div>
                <button id="m_btn_code" type="button" class="btn btn-primary" style="float: right; padding: 6px 8px;width: 39%" onclick="get_code()">获取验证码</button>
            </div>
            <div class="row"></div>
            <div class="form-group">
                <button type="button" id="m_login" class="btn btn-primary btn-block btn-flat">登 录</button>
            </div>
            <div class="row">
                <a href="<?php echo base_url('index.php?/login/password_find');?>" style="margin-right: 30px;float: right">忘记密码</a>
            </div>
        </form>

    </div>
    </div>
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="<?php echo $this->config->item('statics_path'); ?>/jquery/dist/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item('statics_path'); ?>/other/rsa/jsencrypt.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo $this->config->item('statics_path'); ?>/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo $this->config->item('statics_path'); ?>/bootstrapvalidator/js/bootstrapValidator.min.js"></script>
<script src="<?php echo $this->config->item('statics_path'); ?>/bootstrapvalidator/js/language/zh_CN.js"></script>
<script>
    function do_encrypt(id) {
        var encrypt = new JSEncrypt();
        var pubkey = $("#pk").val();
        encrypt.setPublicKey(pubkey); //获取公钥
        return encrypt.encrypt($('#'+id).val());  //加密
    }

    // $('form').bootstrapValidator({
    //     trigger: 'blur'
    // }).on('success.form.bv', function(e) {
    //     e.preventDefault();
    // });

    $('#a_login').click(function () {
        $('#a_form').bootstrapValidator('validate');
        if ($('#a_form').data("bootstrapValidator").isValid())
        {
            $('#a_login').attr('disabled', true);
            //提交逻辑
            var pwd  = do_encrypt('a_password');
            var param = {
                username:$('#a_username').val(),
                password:pwd,
                captcha:$('#a_captcha').val()
            };
            $.post('index.php?/login/ajax_login/', param, function(data){
                if (data.r == 0)
                {
                    location.href = 'index.php?/welcome/index';
                }
                else
                {
                    $('#a_login').attr('disabled', false);
                    $('#a_captcha_img').click();
                    modalOpen(data.m);
                }
            }, "json");
        }
    });

    //管理员登录
    $('#m_login').click(function () {
        $('#m_form').bootstrapValidator('validate');
        if ($('#m_form').data("bootstrapValidator").isValid())
        {
            $('#m_login').attr('disabled', true);
            //提交逻辑
            var code  = do_encrypt('m_code');
            var param = {
                username:$('#m_username').val(),
                code:code,
                captcha:$('#m_captcha').val()
            };
            $.post("<?php echo base_url('index.php?/login/manager_ajax_login/');?>", param, function(data){
                if (data.r == 4000)
                {
                    location.href = "<?php echo base_url('index.php?/welcome/index');?>";
                }
                else
                {
                    $('#m_login').attr('disabled', false);
                    $('#m_captcha_img').click();
                    modalOpen(data.m);
                }
            }, "json");
        }
    });


    function get_code() {
        var phone = $("#m_username").val();
        var captcha = $("#m_captcha").val();

        if (is_phone_no(phone)){

            if (/^\d{4}$/.test(captcha))
            {
                $.post("<?php echo base_url('index.php?/login/manager_send_code');?>", {'phone': phone, 'captcha': captcha}, function(data){
                    if (data.r == 3000)
                    {
                        $('#m_captcha_img').click();
                    }
                    else if(data.r == 4000)
                    {
                        set_time($("#m_btn_code"));
                    }
                    modalOpen(data.m);
                }, "json");
            }
            else
            {
                $('#m_captcha_img').click();
                modalOpen('请输入正确图片二维码')
            }

        }else {
            modalOpen("手机号格式错误");
            $("#m_username").focus();
        }
    }

    var countdown = 60;
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

    function is_phone_no(phone) {
        var pattern = /^1[34578]\d{9}$/;
        return pattern.test(phone);
    }

    function modalOpen(msg) {
        $('#myModalLabel').html('系统提示');
        $('#myModal .modal-body').html(msg);
        $('#myModal').modal();
    }
</script>
</body>
</html>

