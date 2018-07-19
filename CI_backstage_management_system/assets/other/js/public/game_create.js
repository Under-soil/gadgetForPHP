layui.use(['form', 'layer'], function(){
    var layer = layui.layer,
        $ = layui.jquery,
        form = layui.form();
    form.render();
    form.on('submit(add)', function(data) {
        var title = $('input[name=title]').val(),
            name = $('input[name=name]').val(),
            num_index = $('input[name=num_index]').val(),
            param = $('#add').serialize();
        if (title.length <= 0)
        {
            layer.msg('游戏名不能为空', {icon: 2, anim: 6, time: 1000});
            return false;
        }
        if (/^[\u4e00-\u9fa5]{2,10}$/.test(title) == false)
        {
            layer.msg('游戏名格式不正确', {icon: 2, anim: 6, time: 1000});
            return false;
        }

        if (name.length <= 0)
        {
            layer.msg('表名不能为空', {icon: 2, anim: 6, time: 1000});
            return false;
        }
        if (/^[_a-z]{4,20}$/.test(name) == false)
        {
            layer.msg('表名格式不正确', {icon: 2, anim: 6, time: 1000});
            return false;
        }
        if (num_index.length > 0)
        {
            if (/^[_a-z]{4,15}$/.test(num_index) == false)
            {
                layer.msg('房间统计列名格式不正确', {icon: 2, anim: 6, time: 1000});
                return false;
            }
        }
        $.post('index.php?/dev/game/store', param, function(data){
            if (data.r == 4000)
            {
                layer.msg('添加成功', {icon: 1, anim: 6, time: 1000});
                index();
            }
            else if (data.r == 1000)
            {
                window.top.location.reload();
            }
            else
            {
                layer.msg(data.m, {icon: 2, anim: 6, time: 1000});
            }
        }, "json");
        return false;
    });
});

