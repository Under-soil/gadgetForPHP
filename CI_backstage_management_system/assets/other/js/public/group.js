var gridObj;
$(function () {
    gridObj = $.fn.bsgrid.init('searchTable', {
        url: 'index.php?/admin/group/data',
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
    if (record.type == 1)
    {
        opt.push('<a href="javascript:;" ruleid="'+record.id+'" ruletitle="'+record.title+'" onclick="edit(this)">修改</a> |  <a href="javascript:rule('+record.id+');">分配权限</a>');
    } else {
        opt.push('<a href="javascript:;" ruleid="'+record.id+'" ruletitle="'+record.title+'" onclick="edit(this)">修改</a> |  <a href="javascript:rule('+record.id+');">分配权限</a> | <a href="javascript:addUser('+record.id+');">添加成员</a>');
    }

    return opt.join("");
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
                $('.page-content').html(data);
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
                $('.page-content').html(data);
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

