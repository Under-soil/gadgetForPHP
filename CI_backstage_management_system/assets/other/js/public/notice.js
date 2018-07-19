var gridObj = null, detailedObj = null;
$(function () {
    gridObj = $.fn.bsgrid.init('searchTable', {
        url: 'index.php?/tool/notice/data',
        dataType: 'json',
        pageSize: 20,
        stripeRows:true,//隔行换色
        rowHoverColor:true,// 划过行变色
        displayBlankRows:false,//是否显示空白行,
        pageSizeSelect:false,
        align: 'left',
        showPageToolbar:false
    });

});

function operate(record, rowIndex, colIndex, options) {
    var opt = [];
    opt.push('<a href="javascript:if(confirm(\'确定删除？\')) del('+record.id+')">删除</a> |<a href="javascript:;" navId="'+record.id+'" navName="'+record.gid+'"  navTitle="'+record.color+'"  navIndex="'+record.msg+' " onclick="details(this)">查看详情</a>');

    return opt.join("");
}

function operatedetail(record, rowIndex, colIndex, options) {
    var opt = [];
    opt.push('<a href="javascript:;" navId="'+record.msg_id+'" navName="'+record.gid+'" navTitle="'+record.color+'" navIndex="'+record.msg+' " navPid="'+record.pid+'" onclick="edit(this)">修改</a>');

    return opt.join("");
}



function type(record) {
    if (record.type == 2)
    {
        return '通用公告';
    }
    return '区域公告';
}

function scope(record) {
    if (record.color == 1)
    {
        return '大厅';
    }
    return '所有';
}

function gid(record) {
    if (record.pid == -1)
    {
        return '通用';
    }
    return record['name'];
}

// 添加公告
function add(){
    $('#addtype').val('-1');
    $('#addcolor').val('2');
    $("textarea[name='msg']").val('');
    $('#form-add').modal('show');
}

function details(obj) {
    $('#detail').show();
    var navId=$(obj).attr('navId'),
        navName=$(obj).attr('navName'),
        navTitle=$(obj).attr('navTitle'),
        navIndex=$(obj).attr('navIndex');
    var a = 'index.php?/tool/notice/detailed'
    var b =navId
    var url = a+"?id="+b;
    detailedObj = $.fn.bsgrid.init('detailedTable',{
        url:url ,
        dataType: 'json',
        pageSize: 100,
        refreshPage:false,
        stripeRows:true,//隔行换色
        rowHoverColor:true,// 划过行变色
        displayBlankRows:false,//是否显示空白行,
        pageSizeSelect:true,
        align: 'left',
        showPageToolbar:false
    });
}

function edit(obj){
    var navId=$(obj).attr('navId'),
        navName=$(obj).attr('navName'),
        navTitle=$(obj).attr('navTitle'),
        navIndex=$(obj).attr('navIndex');
    navpid =$(obj).attr('navPid');
    $("input[name='msg_id']").val(navId);
    $("input[name='pid']").val(navpid);
    $("input[name='gid']").val(navName);
    $("select[name='color']").val(navTitle);
    $("textarea[name='msg']").val(navIndex);
    $('#form-edit').modal('show');
}

function pack() {
    $('#detail').hide();
}

layui.use(['form', 'layer'], function(){
    var layer = layui.layer,
        $ = layui.jquery,
        form = layui.form();
    form.render();
    form.on('submit(addstore)', function(data) {
        var param = $('#store').serialize();
        $.post('index.php?/tool/notice/store', param, function(data){
            if (data.r == 4000)
            {
                layer.msg('添加成功', {icon: 1, anim: 6, time: 1000});
                $('#detail').hide();
                $('#form-add').modal('hide');
                $('.modal-backdrop').hide();
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

    form.on('submit(editsave)', function(data) {
        var param = $('#save').serialize();

        $.post('index.php?/tool/notice/save', param, function(data){
            if (data.r == 4000)
            {
                layer.msg('保存成功', {icon: 1, anim: 6, time: 1000});
                $('#form-edit').modal('hide');
                $('#detail').hide();
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


function del(id) {
    $.post('index.php?/tool/notice/delete', {'id': id}, function(data){
        if (data.r == 4000)
        {
            bootbox.alert("删除成功");
            $('#detail').hide();
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


