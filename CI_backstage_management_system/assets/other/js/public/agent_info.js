layui.use(['form', 'layer'], function(){
    var form = layui.form();
    var $ = layui.jquery;
    form.render();

    $('#query').on('click', function(){
        var DISABLED = 'layui-btn-disabled';
        if($(this).hasClass(DISABLED)) return;
        $(this).addClass(DISABLED);
        var value = $('#amount').val();
        var max = $('#amount').attr('max');
        var min = $('#amount').attr('min');
        var balance = $('#balance').val();
        var level = $('#level').val();
        var root_level = $('#root_level').val();
        if(root_level == level){
            layer.msg("管理员无取款功能", {icon: 2, anim: 6, time: 1000});
            return false;
        }
        if( /^[0-9]*$/.test(value) == false){
            layer.msg("取款金额格式不正确", {icon: 2, anim: 6, time: 1000});
            $(this).removeClass(DISABLED);
            return false;
        }
        if(value - max > 0){
            layer.msg("取款金额超出限额，最大限额"+max+"元", {icon: 2, anim: 6, time: 1000});
            $(this).removeClass(DISABLED);
            return false;
        }
        if(min - value > 0){
            layer.msg("取款金额不能少于"+min+"元", {icon: 2, anim: 6, time: 1000});
            $(this).removeClass(DISABLED);
            return false;
        }
        if(balance - value < 0){
            var msg = '余额不足';
            layer.msg(msg, {icon: 2, anim: 6, time: 2000});
            $(this).removeClass(DISABLED);
            return false;
        }
        loading = layer.load(2, {
            shade: [0.2,'#000'] //0.2透明度的白色背景
        });

        var amount = $('#amount').val();
        var param = {"amount":amount};
        $.post('index.php?/agent/agent_info/transfers/', param, function(data){
            if (data.r == 4000)
            {
                layer.close(loading);
                layer.msg(data.m);
                $('#balance').html(data.balance + ' 元');
            }
            else if (data.r == 1000)
            {
                layer.close(loading);
                layer.msg("取款失败");
                top.document.location.reload();
            }
            else if(data.r == 2 || data.r == 5) {
                layer.close(loading);
                layer.msg(data.m, {icon: 2, anim: 6, time: 1000});
            } else if (data.r == 6) {
                layer.close(loading);
                //再次请求
                var t1 = setInterval(function () {
                    $.post('index.php?/agent/agent_info/auto_transfer/', {id: data.id}, function(data){
                        if (data.r == 4000)
                        {
                            window.clearInterval(t1);
                            layer.msg('取款成功', {icon: 1, anim: 6, time: 1000});
                            $('#balance').html(data.balance + ' 元');
                        }
                        else if (data.r == 1000)
                        {
                            top.document.location.reload();
                        } else if(data.r != 1)
                        {
                            layer.msg(data.m, {icon: 2, anim: 6, time: 1000});
                            window.clearInterval(t1);
                        } else {
                            layer.msg(data.m);
                        }
                    }, "json");
                }, 3000);
            }
            else
            {
                layer.close(loading);
                layer.msg(data.m, {icon: 2, anim: 6, time: 1000});
                $(this).removeClass(DISABLED);
            }
        }, "json");

    });
});