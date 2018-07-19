var gridObj;
$(function () {
    gridObj = $.fn.bsgrid.init('searchTable', {
        url: 'index.php?/admin/user/data',
        dataType: 'json',
        pageSize: 20,
        stripeRows:true,//隔行换色
        rowHoverColor:true,// 划过行变色
        displayBlankRows:false,//是否显示空白行,
        pageSizeSelect:false,
        align: 'left',
    });
});

function operate(record, rowIndex, colIndex, options) {
    var opt = [];
    if (record.state == 1) {
        opt.push('<a href="javascript:if(confirm(\'确定禁用？\'))update('+record.id+','+record.level+', 0)">禁用</a>');
    } else {
        opt.push('<a href="javascript:if(confirm(\'确定启用？\'))update('+record.id+','+record.level+', 1)">启用</a>');
    }
    return opt.join("");
}

function level_name(record, rowIndex, colIndex, options) {
    return $('#h_group_'+record.level).val();
}

function state_name(record, rowIndex, colIndex, options) {
    if (record.state == 1)
    {
        return '启用';
    }
    return '禁用';
}

function addUser(id) {
    var url = 'index.php?/admin/user/view/'+id;
    $.ajax({
        url: url,
        async:false,
        type:'post',
        dataType:'html',
        success:function(data) {
            if(!data.match("^\{(.+:.+,*){1,}\}$"))
            {
                $('.main-content').html(data);
            } else {
                var obj = eval('(' + data + ')');
                if (obj.r == 1000)
                {
                    window.top.location.reload();
                } else
                {
                    bootbox.alert(obj.m);
                }
            }
        }
    });
}

function rule(id) {
    var url = 'index.php?/admin/group/rule/'+id;
    $.ajax({
        url: url,
        async:false,
        type:'post',
        dataType:'html',
        success:function(data) {
            if(!data.match("^\{(.+:.+,*){1,}\}$"))
            {
                $('.main-content').html(data);
            } else {
                var obj = eval('(' + data + ')');
                if (obj.r == 1000)
                {
                    window.top.location.reload();
                } else
                {
                    bootbox.alert(obj.m);
                }
            }
        }
    });
}
// 添加菜单
function add(){
    $("input[name='title']").val('');
    $('#form-add').modal('show');
}
// 修改菜单
function edit(obj){
    var ruleId=$(obj).attr('ruleId');
    var ruletitle=$(obj).attr('ruletitle');
    $("input[name='id']").val(ruleId);
    $("input[name='title']").val(ruletitle);
    $('#form-edit').modal('show');
}
function update(id, level, state) {
    $.post('index.php?/admin/user/setState', {'id': id, 'level':level, 'opt':state}, function(data){
        if (data.r == 4000)
        {
            layer.msg('设置成功', {icon: 1, anim: 6, time: 1000});
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

    form.on('submit(add)', function(data) {
        var param = $('#add').serialize();
        $.post('index.php?/admin/group/add', param, function(data){
            if (data.r == 4000)
            {
                $('#form-add').modal('hide');
                layer.msg('添加成功', {icon: 1, anim: 6, time: 1000});
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
        return false;
    });

    form.on('submit(edit)', function(data) {
        var param = $('#edit').serialize();
        $.post('index.php?/admin/group/edit', param, function(data){
            if (data.r == 4000)
            {
                $('#form-edit').modal('hide');
                layer.msg('修改成功', {icon: 1, anim: 6, time: 1000});
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
        return false;
    });
});

