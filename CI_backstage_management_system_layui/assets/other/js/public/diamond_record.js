var listObj = null;

function deal_desc(record) {
    if(record.desc){
        return '<xmp>'+record.desc+'</xmp>';
    }
    return '';
}

$(function () {
    listObj = $.fn.bsgrid.init('listTable', {
        url: 'index.php?/tool/diamond/data/',
        dataType: 'json',
        pageSize: 20,
        stripeRows:true,//隔行换色
        rowHoverColor:true,// 划过行变色
        displayBlankRows:false,//是否显示空白行,
        pageSizeSelect:false,
    });
});

    layui.use(['form', 'layer'], function(){
        var form = layui.form();
        var $ = layui.jquery;
        form.render();
        form.verify({
            appuid:function (value) {
                if((value.length>0) && (/^\d{8}$/.test(value) == false)){
                    return "游戏用户ID为8位数字";
                }
            }
        });
        //查询提交
    form.on('submit(query)', function(data){
        //用户新增 验证
        $('#num').val('');
        var appuid = $('#appuid').val();
        var nickname = $('#nickname').val();
        if((appuid.length>0) && (/^\d{8}$/.test(appuid) == false)){
            layer.msg("游戏用户ID为8位数字", {icon: 2, anim: 6, time: 1000});
            return false;
        }
        listObj.search(data.field);
        return false;
    });
});

