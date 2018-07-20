function checkAll(obj){
    $(obj).parents('.b-group').eq(0).find("input[type='checkbox']").prop('checked', $(obj).prop('checked'));
}

layui.use(['form', 'layer'], function(){
    var layer = layui.layer,
        $ = layui.jquery,
        form = layui.form();
    form.render();

    form.on('submit(submit)', function(data) {
        var param = $('#rule').serialize();
        $.post('index.php?/admin/group/deal', param, function(data){
            if (data.r == 4000)
            {
                layer.msg('分配成功', {icon: 1, anim: 6, time: 1000});

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

