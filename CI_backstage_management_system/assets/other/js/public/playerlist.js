var gridObj;
$(function () {
    gridObj = $.fn.bsgrid.init('searchTable', {
        url: 'index.php?/game/playerlist/data/',
        dataType: 'json',
        pageSize: 20,
        stripeRows:true,//隔行换色
        rowHoverColor:true,// 划过行变色
        displayBlankRows:false,//是否显示空白行,
        pageSizeSelect:false,
    });
});

function operate(record, rowIndex, colIndex, options)
{
    var opt = [];
    if (record.biaoji == -1) {
        opt.push('<button class="layui-btn  layui-btn-small  layui-btn-normal" uid="' + record.id + '" onclick="setstate(this, 1)">解除红名</button>&nbsp;&nbsp;');
    } else
    {
        opt.push('<button class="layui-btn layui-btn-small layui-btn-normal layui-btn-danger" uid="' + record.id + '" onclick="setstate(this, -1)">设置红名</button>&nbsp;&nbsp;');
    }
    if (record.status == 2) {
        opt.push('<button class="layui-btn  layui-btn-small layui-btn-normal" uid="' + record.id + '" onclick="set_biaoji(this, 1)">解除封号</button>&nbsp;&nbsp;');
    } else {
        opt.push('<button class="layui-btn layui-btn-small  layui-btn-normal layui-btn-danger" uid="' + record.id + '" onclick="set_biaoji(this, 2)">玩家封号</button>&nbsp;&nbsp;');
    }

    return opt.join("");
}

function setstate(btn, opt){
    var uid = $(btn).attr('uid');
    loading = layer.load(2, {
        shade: [0.2,'#000'] //0.2透明度的白色背景
    });

    var param = {"uid":uid, "opt":opt};
    $.post('index.php?/game/playerlist/setstate/', param, function(data){
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

function set_biaoji(btn, opt){
    var uid = $(btn).attr('uid');
    loading = layer.load(2, {
        shade: [0.2,'#000'] //0.2透明度的白色背景
    });

    var param = {"uid":uid, "opt":opt};
    $.post('index.php?/game/playerlist/setban/', param, function(data){
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
    return false;
}

layui.use('form', function(){
    var form = layui.form();

    //查询提交
    form.on('submit(query)', function(data){
        gridObj.search(data.field);

        return false;
    });
});