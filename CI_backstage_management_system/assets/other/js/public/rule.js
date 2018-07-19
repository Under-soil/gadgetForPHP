var gridObj;
$(function () {
    gridObj = $.fn.bsgrid.init('searchTable', {
        url: 'index.php?/admin/rule/data',
        dataType: 'json',
        pageSize: 999,
        stripeRows:true,//隔行换色
        rowHoverColor:true,// 划过行变色
        displayBlankRows:false,//是否显示空白行,
        pageSizeSelect:false,
        align: 'left',
    });
});
setTimeout(function () {
    if (gridObj && gridObj.getTotalRows() > 1) {
        if ($('.order').length <= 0)
        {
            $('#searchTable').children(":last-child").after('<tr><td></td><th><input class="btn btn-success order" type="submit" lay-submit lay-filter="order" value="变更"></th><td></td><td></td><td></td></tr>');
        }
    }
}, 2000);

function operate(record, rowIndex, colIndex, options) {
    var opt = [];
    if (record._level < 3) {
        opt.push('<a href="javascript:;" ruleid="'+record.id+'" rulename="'+record.name+'" ruletitle="'+record.title+'" ruleorder_number="'+record.order_number+'" ruleico="'+record.ico+'"  onclick="edit(this)">修改</a> | <a href="javascript:if(confirm(\'确定删除？\'))del('+record.id+')">删除</a> | <a href="javascript:;" ruleid="'+record.id+'" onclick="add_child(this)">添加子权限</a>');
    } else {
        opt.push('<a href="javascript:;" ruleid="'+record.id+'" rulename="'+record.name+'" ruletitle="'+record.title+'" ruleorder_number="'+record.order_number+'" ruleico="'+record.ico+'" onclick="edit(this)">修改</a> | <a href="javascript:if(confirm(\'确定删除？\'))del('+record.id+')">删除</a>');
    }
    return opt.join("");
}

function show_input(record, rowIndex, colIndex, options) {
    var opt = [];
    if (!record.pid) record.pid = 0;
    opt.push('<input class="input-medium" style="width:40px;height:25px;" type="text" name="'+record.id+'" value="'+record.pid+'" />');
    return opt.join("");
}

// 添加菜单
function add(){
    $("input[name='title'],input[name='name']").val('');
    $("input[name='pid']").val(0);
    $('#form-add').modal('show');
}
// 添加子菜单
function add_child(obj){
    var ruleId=$(obj).attr('ruleId');
    $("input[name='pid']").val(ruleId);
    $("input[name='title']").val('');
    $("input[name='name']").val('');
    $("input[name='order_number']").val('');
    $("input[name='ico']").val('');
    $('#form-add').modal('show');
}
// 修改菜单
function edit(obj){
    var ruleId=$(obj).attr('ruleId');
    var ruletitle=$(obj).attr('ruletitle');
    var ruleName=$(obj).attr('ruleName');
    $("input[name='id']").val(ruleId);
    $("input[name='title']").val(ruletitle);
    $("input[name='name']").val(ruleName);
    $("input[name='order_number']").val($(obj).attr('ruleorder_number'));
    $("input[name='ico']").val($(obj).attr('ruleico'));
    $('#form-edit').modal('show');
}

function del(id) {
    $.post('index.php?/admin/rule/delete', {'id': id}, function(data){
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

    form.on('submit(ruleadd)', function(data) {
        var rule = $('#form-add input[name=name]').val();
        if ( /^[a-z][a-z_\/]{0,78}[a-z]$/.test(rule) == false)
        {
            layer.msg('链接格式不正确', {icon: 2, anim: 6, time: 1000});
            return false;
        }
        var param = $('#form-form').serialize();
        $.post('index.php?/admin/rule/add', param, function(data){
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

    form.on('submit(ruleedit)', function(data) {
        var rule = $('#form-edit input[name=name]').val();
        if ( /^[a-z][a-z_\/]{0,78}[a-z]$/.test(rule) == false)
        {
            layer.msg('链接格式不正确', {icon: 2, anim: 6, time: 1000});
            return false;
        }
        var param = $('#edit-form').serialize();
        $.post('index.php?/admin/rule/edit', param, function(data){
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

    form.on('submit(order)', function(data) {
        var param = $('#order').serialize();
        $.post('index.php?/admin/rule/order', param, function(data){
            if (data.r == 4000)
            {
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

