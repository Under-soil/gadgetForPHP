 function state_name(record, rowIndex, colIndex, options) {
        if (record.state == 2)
        {
            return '取款成功';
        }
        return '取款失败';
    }

function deal_amount(record, rowIndex, colIndex, options) {
    if (record.state == 2)
    {
        return record.amount;
    }
    return 0;
}
var gridObj;
$(function () {
    gridObj = $.fn.bsgrid.init('searchTable', {
        url: 'index.php?/withdraw/record/data/',
        dataType: 'json',
        pageSize: 20,
        stripeRows:true,//隔行换色
        rowHoverColor:true,// 划过行变色
        displayBlankRows:false,//是否显示空白行,
        pageSizeSelect:false,
        pagingToolbarAlign:'left',
    });
    setTimeout(function () {
        if(gridObj && gridObj.getTotalRows() > 0){
            var sum = gridObj.getRecord(0);
            if(sum && sum.sum){
                $('.bsgridPaging>tbody>tr').find('td').eq(1).after('<td class="sum">取款总额：'+sum.sum+'元</td>');
                $('.bsgridPaging').css('width', '98%');

            }
        }
    },2500);

    layui.use(['form', 'laydate'], function(){
        var form = layui.form();
        form.render();
        var laydate = layui.laydate;
        var start = {
            max:laydate.now(),
            istime: true,
            format: 'YYYY-MM-DD hh:mm',
            choose: function(datas){
                end.min = datas; //开始日选好后，重置结束日的最小日期
                end.start = datas //将结束日的初始值设定为开始日
            }
        };
        var end = {
            max:laydate.now(),
            istime: true,
            format: 'YYYY-MM-DD hh:mm',
            choose: function(datas){
                start.max = datas; //结束日选好后，重置开始日的最大日期
            }
        };

        $('#range_s').on('click', function(){
            start.elem = this;
            laydate(start);
        });
        $('#range_e').on('click', function(){
            end.elem = this;
            laydate(end);
        });
        form.verify({
            code:function(value){
                if(value.length>0){
                    if (/^\d{5}$/.test(value) == false && /^\d{4}$/.test(value) == false)
                    {
                        return "邀请码为5位数字,区域ID为4位数字";
                    }
                }
            }
        });
        //监听提交
        form.on('submit(query)', function(data){
            $("#searchTable").show();
            gridObj.search(data.field);
            setTimeout(function () {
                if(gridObj && gridObj.getTotalRows() > 0){
                    var sum = gridObj.getRecord(0);
                    $('.sum').remove();
                    if(sum && sum.sum){
                        $('.bsgridPaging>tbody>tr').find('td').eq(1).after('<td class="sum">取款总额：'+sum.sum+'元</td>');
                    }
                }
            },2500);
            return false;
        });
    });
    $('#range_s').removeAttr('disabled');
    $('#range_e').removeAttr('disabled');
});