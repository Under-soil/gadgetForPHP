$(function() {
    var aStr = ["弱", "中", "强"];

    function checkStrong(val) {
        var modes = 0;
        if (val.length < 6) return 0;
        if (/\d/.test(val)) modes++; //数字
        if (/[a-z]/.test(val)) modes++; //小写
        if (/[A-Z]/.test(val)) modes++; //大写
        if (/\W/.test(val)) modes++; //特殊字符
        return modes;
    };
    $("#newpassword").keyup(function() {
        var val = $(this).val();
        if (val.length < 6)
        {
            $('#tips span').css('background-color', 'white');
            return false;
        }
        if ($('#tips').length <= 0) {
            var html = '<div class="layui-form-item"><div id="tips" ><span></span><span></span><span></span></div></div>';
            $('#pwd').after(html);
        }
        var num = checkStrong(val);
        switch (num) {
            case 0:
                break;
            case 1:
                $("#tips span").css('background', 'yellow').text('').eq(num - 1).css('background-color', 'red').text(aStr[num - 1]);
                break;
            case 2:
                $("#tips span").css('background', 'green').text('').eq(num - 1).css('background-color', 'red').text(aStr[num - 1]);
                break;
            case 3:
                $("#tips span").css('background', 'green').text('').eq(num - 1).css('background-color', 'red').text(aStr[num - 1]);
                break;
            default:
                break;
        }
    })

    $('button[type=reset]').click(function () {
        $('#tips span').css('background-color', 'white');
    });
});

layui.use(['form', 'layer'], function(){
    var form = layui.form();
    var $ = layui.jquery;

        //用户新增 显示
        $("#menu-reset-pwd").on('click', function() {
            $('#form-reset-pwd')[0].reset();
            $('#tips span').css('background-color', 'white');

            layer.open({
                type: 1
                ,title: ['修改密码', 'font-size:16px; text-align:center']
                ,closeBtn: 1
                ,area: 'auto'
                ,shade: [0.2, '#393D49']
                ,id: 'LAY_layuipro'
                ,move: true
                ,content: $('#layer-reset-pwd')
                ,success: function(layero){
                }
            });
        });

        form.verify({
        newpassword: function (value) {
            if ( /(?!^\[0-9]+$)(?!^[a-zA-Z]+$)(?!^[_#@]+$).{6,20}/.test(value) == false)
            {
                return '新密码必须6到20位且不能出现空格';
            }
            if(/(\s+)/.test(value) == true){
                return  '密码不能包含空格';
            }
        },
        passconf:function(value){
            if (value != $("#newpassword").val())
            {
                return '密码和确认密码不一致';
            }
        },
        });

        //用户新增 提交
        form.on('submit(pwdreset)', function(data) {
            var flag = '';
            $("#tips span").each(function(){
                flag = $(this).text();
                if (flag.length > 0)
                {
                    return false;
                }
            });
            if (flag == '弱')
            {
                layer.msg("密码过于简单");
                return false;
            }
            loading = layer.load(2, {
                shade: [0.2,'#000'] //0.2透明度的白色背景
            });

            var param = data.field;
            $.post('index.php?/login/pwdUpdate/', param, function(data){
                layer.close(loading);
                if (data.r == 4000)
                {
                    layer.msg("修改成功");
                    layer.closeAll('page');
                    window.location.href = 'index.php?/Login/logout/';
                }
                else if (data.r == 1000)
                {
                    top.document.location.reload();
                }
                else
                {
                    layer.msg(data.m, {icon: 2, anim: 6, time: 1000});
                }
            }, "json");
            return false;
        });
    });

