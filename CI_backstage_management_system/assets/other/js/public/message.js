var gridObj;
$(function () {
    gridObj = $.fn.bsgrid.init('searchTable', {
        url: 'index.php?/tool/message/data/',
        dataType: 'json',
        // pageSize: 20,
        stripeRows:true,//隔行换色
        rowHoverColor:true,// 划过行变色
        displayBlankRows:false,//是否显示空白行,
        pageSizeSelect:false,
        showPageToolbar:true
    });
});

function operate(record, rowIndex, colIndex, options) {
    var opt = [];
    if (record.status != 1)
    {
        opt.push('<a href="javascript:setstate( 1, '+record.id+');"  >启用</a> | ');
    }
    else
    {
        opt.push('<a href="javascript:setstate( 0, '+record.id+');"  >禁用</a> | ');
    }
    opt.push('<a href="javascript:;" navId="'+record.msg_id+'" navName="'+record.start_time+'" navTitle="'+record.end_time+'" onclick="edit(this)">编辑</a> ');
    return opt.join("");
}

function setstate(opt, id){
    loading = layer.load(2, {
        shade: [0.2,'#000'] //0.2透明度的白色背景
    });

    var param = {"id":id, "opt":opt};
    $.post('index.php?/tool/message/setstate/', param, function(data){
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


function publish(){
    loading = layer.load(2, {
        shade: [0.2,'#000'] //0.2透明度的白色背景
    });
    $.post('index.php?/tool/message/publish/', function(data){
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


// 添加公告
function add(){
    $("input[name='msg_id']").val('');
    $("input[name='range_s']").val('');
    $("input[name='range_e']").val('');
    $('#form-add').modal('show');
}


// 修改公告
function edit(obj){
    var navId=$(obj).attr('navId'),
        navName=$(obj).attr('navName'),
        navTitle=$(obj).attr('navTitle'),
        navIndex=$(obj).attr('navIndex');
    $("input[name='msg_id']").val(navId);
    $("input[name='start_time']").val(navName);
    $("input[name='end_time']").val(navTitle);
    $('#form-edit').modal('show');
}

layui.use(['form', 'laydate'], function () {
    var form = layui.form();

    var laydate = layui.laydate;

    var start = {
        // max: laydate.now(),
        istime: true,
        format: 'YYYY-MM-DD hh:mm:ss',
        choose: function (datas) {
            end.min = datas; //开始日选好后，重置结束日的最小日期
            end.start = datas //将结束日的初始值设定为开始日
        }
    };

    var end = {
        // max: laydate.now(),
        istime: true,
        format: 'YYYY-MM-DD hh:mm:ss',
        choose: function (datas) {
            start.max = datas; //结束日选好后，重置开始日的最大日期
        }
    };

    $('#start_time').on('click', function () {
        start.elem = this;
        laydate(start);
    });

    $('#end_time').on('click', function () {
        end.elem = this
        laydate(end);
    });

    $('#range_s').on('click', function () {
        start.elem = this;
        laydate(start);
    });

    $('#range_e').on('click', function () {
        end.elem = this
        laydate(end);
    });

    form.on('submit(add)', function(data) {
        var param = $('#add-form').serialize();
        $.post('index.php?/tool/message/store', param, function(data){
            if (data.r == 4000)
            {
                layer.msg('添加成功', {icon: 1, anim: 6, time: 1000});
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

    //监听提交
    form.on('submit(edit)', function(data) {

        var param = $('#edit-form').serialize();
        $.post('index.php?/tool/message/save', param, function(data){
            if (data.r == 4000)
            {
                $('#form-edit').modal('hide');
                bootbox.alert('修改成功');
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
