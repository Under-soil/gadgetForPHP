function do_encrypt() {
    var encrypt = new JSEncrypt();
    var pubkey = $("#pk").val();
    encrypt.setPublicKey(pubkey); //获取公钥
    return encrypt.encrypt($('#password').val());  //加密
}

layui.use(['form', 'layer'],function(){
    var form = layui.form()
        ,$ = layui.jquery;
    //监听提交
    form.on('submit(login)', function(data){
        var pwd  = do_encrypt();
        data.field.password = pwd;
        $.post('index.php?/login/ajax_login/', data.field, function(data){ 
            if (data.r == 4000)
            {
                location.href = 'index.php?/welcome/';
            }
            else
            {
                layer.msg(data.m, {icon: 2, anim: 6, time: 4000});
                $('.captcha').click();
            }
        }, "json");
        return false;
    });
});

jQuery(function($) {
    $(document).on('click', '.toolbar a[data-target]', function(e) {
        e.preventDefault();
        var target = $(this).data('target');
        $('.widget-box.visible').removeClass('visible');//hide others
        $(target).addClass('visible');//show target
    });
    setInterval(timeFunction, 3600000);

    $('.captcha').bind('click', function () {
        $('.captcha').src="index.php?/captcha/gen/"+Math.random();
    });
});
function timeFunction() {
    $('.captcha').click();
}