layui.use(['form', 'layer'], function(){
    var layer = layui.layer,
        $ = layui.jquery,
        form = layui.form();
    form.render();
    form.on('submit(add)', function(data) {
        param = $('#add').serialize();
        if (username.length <= 0)
        {
            layer.msg('用户名不能为空', {icon: 2, anim: 6, time: 1000});
            return false;
        }
        if (passwd.length <= 0)
        {
            layer.msg('密码不能为空', {icon: 2, anim: 6, time: 1000});
            return false;
        }
        $.post('index.php?/admin/user/add', param, function(data){
            if (data.r == 4000)
            {
                layer.msg('添加成功', {icon: 1, anim: 6, time: 1000});

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
