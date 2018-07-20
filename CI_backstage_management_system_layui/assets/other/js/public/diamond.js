var gridObj = null;

function deal_desc(record) {
    if(record.desc){
        return '<xmp>'+record.desc+'</xmp>';
    }
    return '';
}
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
        $('#desc').val('');
        $('.layui-table').hide();
        var appuid = $('#appuid').val();
        var nickname = $('#nickname').val();
        if(appuid.length == 0){
            layer.msg("请选择筛选条件", {icon: 2, anim: 6, time: 1000});
            return false;
        }
        if((appuid.length>0) && (/^\d{8}$/.test(appuid) == false)){
            layer.msg("游戏用户ID为8位数字", {icon: 2, anim: 6, time: 1000});
            return false;
        }
        if(gridObj){
            gridObj.search(data.field);
        }else{
            gridObj = $.fn.bsgrid.init('searchTable', {
                url: 'index.php?/tool/diamond/player/',
                dataType: 'json',
                pageSize: 20,
                stripeRows:true,//隔行换色
                rowHoverColor:true,// 划过行变色
                displayBlankRows:false,//是否显示空白行,
                pageSizeSelect:false,
                otherParames:data.field,
            });
        }
        $('#searchTable').show();
        if(appuid.length > 0){
            $('.layui-table').show();
        }
        return false;
    });


    $('#submit').on('click', function(){
        var value = $('#num').val();
        var max = $('#num').attr('max');
        var min = $('#num').attr('min');
        var appuid = $('#appuid').val();
        if( /^[0-9]*$/.test(value) == false){
            layer.msg("加钻数量格式不正确", {icon: 2, anim: 6, time: 1000});
            return false;
        }
        if(value - max > 0){
            layer.msg("加钻数量超出限额，最大限额"+max+"个", {icon: 2, anim: 6, time: 1000});
            return false;
        }
        if(min - value >= 0){
            layer.msg("加钻数量不能少于"+min+"个", {icon: 2, anim: 6, time: 1000});
            return false;
        }
        if((appuid.length>0) && (/^\d{8}$/.test(appuid) == false)){
            layer.msg("游戏用户ID为8位数字", {icon: 2, anim: 6, time: 1000});
            return false;
        }
        layer.confirm('您确定向此玩家加钻'+value+'吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            loading = layer.load(2, {
                shade: [0.2,'#000'] //0.2透明度的白色背景
            });
            var param = {'appuid': appuid, 'num':value, 'desc':$('#desc').val()};
            $.post('index.php?/tool/diamond/save/', param, function(data){
                layer.close(loading);
                if (data.r == 4000)
                {
                    layer.msg("添加成功");
                    $('#query').click();
                }
                else if (data.r == 1000)
                {
                    layer.msg("添加失败");
                    top.document.location.reload();
                }
                else
                {
                    layer.msg(data.m, {icon: 2, anim: 6, time: 1000});
                }
            }, "json");
        }, function(){
        });
    });
});

