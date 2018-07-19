var gridObj = null, listObj = null;

function biaoji_name(record, rowIndex, colIndex, options) {
    if (record.biaoji == -1)
    {
        return '红名状态'
    }
    return '正常';
}

function level_name(record, rowIndex, colIndex, options) {
    return $('#h_group_'+record.level).val();
}

function state_name(record, rowIndex, colIndex, options) {
    if (record.pay_status == 2)
    {
        return '成功';
    }
    return '失败';
}

layui.use(['form', 'layer'], function(){
    var form = layui.form();
    var $ = layui.jquery;
    //用户新增 验证
    form.verify({
        appuid:function(value){
            if ( /^\d{8}$/.test(value) == false)
            {
                return "游戏用户ID为8位数字";
            }
        }
    });
    //监听提交
    form.on('submit(query)', function(data){
        $("#searchTable").show();
        if (!gridObj)
        {
            gridObj = $.fn.bsgrid.init('searchTable', {
                url: 'index.php?/agent/player_query/data/',
                dataType: 'json',
                pageSize: 1,
                stripeRows:true,//隔行换色
                rowHoverColor:true,// 划过行变色
                displayBlankRows:false,//是否显示空白行,
                pageSizeSelect:false,
                showPageToolbar:false,
                otherParames:data.field,
            });
        }
        else
        {
            gridObj.search(data.field);
        }
        return false;
    });
});
