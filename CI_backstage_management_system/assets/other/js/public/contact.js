var gridObj;
$(function () {
    gridObj = $.fn.bsgrid.init('searchTable', {
        url: 'index.php?/tool/contact/data/',
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
    opt.push('<a href="javascript:;"   navAgent="'+record.agent_qq_qun+'"  navWechat="'+record.wechat_gongzhonghao+'"  navKefu="'+record.kefu_qq+'"  onclick="edit(this)">修改</a>');
    return opt.join("");
}
//刷新列表
function publish(){
    loading = layer.load(2, {
        shade: [0.2,'#000'] //0.2透明度的白色背景
    });
    $.post('index.php?/tool/contact/publish/', function(data){
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

//修改联系人
function edit(obj){
    var navAgent=$(obj).attr('navAgent');
    navWechat=$(obj).attr('navWechat')
    navKefu=$(obj).attr('navKefu'),
    $("input[name='agent_qq_qun']").val(navAgent);
    $("input[name='wechat_gongzhonghao']").val(navWechat);
    $("input[name='kefu_qq']").val(navKefu);
    $('#form-edit').modal('show');
}
layui.use(['form', 'layer'], function(){
    var form = layui.form();
    var $ = layui.jquery;
    form.on('submit(editsave)', function(data) {
        var param = $('#save').serialize();
        $.post('index.php?/tool/contact/save', param, function(data){
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


