var gridObj;
$(function () {
    gridObj = $.fn.bsgrid.init('searchTable', {
        url: 'index.php?/dev/game/data',
        dataType: 'json',
        pageSize: 20,
        stripeRows:true,//隔行换色
        rowHoverColor:true,// 划过行变色
        displayBlankRows:false,//是否显示空白行,
        pageSizeSelect:false,
        showPageToolbar:true
    });
});

function operate(record, rowIndex, colIndex, options) {
    var opt = [];
    if (record.state != 1)
    {
        opt.push('<a href="javascript:setstate( 1, '+record.id+');"  >启用</a> | ');
    }
    else
    {
        opt.push('<a href="javascript:setstate( 0, '+record.id+');"  >禁用</a> | ');
    }
    opt.push('<a href="javascript:;" navId="'+record.id+'" navName="'+record.name+'" navTitle="'+record.title+'" navIndex="'+record.num_index+'" onclick="edit(this)">修改</a> | <a href="javascript:if(confirm(\'确定删除？\')) del('+record.id+')">删除</a>');

    return opt.join("");
}

function setstate(opt, id){
    loading = layer.load(2, {
        shade: [0.2,'#000'] //0.2透明度的白色背景
    });

    var param = {"id":id, "opt":opt};
    $.post('index.php?/dev/game/setstate', param, function(data){
        layer.close(loading);
        if (data.r == 4000)
        {
            gridObj.refreshPage();
            layer.closeAll('page');
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
}

// 修改菜单
function edit(obj){
    var navId=$(obj).attr('navId'),
        navName=$(obj).attr('navName'),
        navTitle=$(obj).attr('navTitle'),
        navIndex=$(obj).attr('navIndex');
    $("input[name='id']").val(navId);
    $("input[name='name']").val(navName);
    $("input[name='title']").val(navTitle);
    $("input[name='num_index']").val(navIndex);
    $('#form-edit').modal('show');
}

function del(id) {
    $.post('index.php?/dev/game/delete', {'id': id}, function(data){
        if (data.r == 4000)
        {
            layer.msg('删除成功', {icon: 1, anim: 6, time: 1000});
            gridObj.refreshPage();
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
}

layui.use(['form', 'layer'], function(){
    var layer = layui.layer,
        $ = layui.jquery,
        form = layui.form();
    form.render();

    form.on('submit(menuedit)', function(data) {
        var name = $('#edit-form input[name=name]').val(),
            title = $('#edit-form input[name=title]').val(),
            num_index = $('#edit-form input[name=num_index]').val()
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
        var param = $('#edit-form').serialize();
        $.post('index.php?/dev/game/save', param, function(data){
            if (data.r == 4000)
            {
                $('#form-edit').modal('hide');
                bootbox.alert('修改成功');
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
