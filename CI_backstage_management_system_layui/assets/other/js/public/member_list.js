var gridObj;
$(function () {
    gridObj = $.fn.bsgrid.init('searchTable', {
        url: 'index.php?/agent/member_list/data/',
        dataType: 'json',
        pageSize: 20,
        stripeRows:true,//隔行换色
        rowHoverColor:true,// 划过行变色
        displayBlankRows:false,//是否显示空白行,
        pageSizeSelect:false,
    });
});

layui.use(['form'], function(){
    var form = layui.form();
    form.render();
    //验证
    form.verify({
        appuid:function (value) {
            if((value.length>0) && (/^\d{8}$/.test(value) == false)){
                return "游戏用户ID为8位数字";
            }
        }
    });
    //监听提交
    form.on('submit(query)', function(data){
        gridObj.search(data.field);
        return false;
    });
});

function operate(record, rowIndex, colIndex, options) {
    return '<a href="#" onclick="alert(\'ID=' + gridObj.getRecordIndexValue(record, 'ID') + '\');">Operate</a>';
}
