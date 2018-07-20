function calc_bind(record) {
    if(summaryObj && summaryObj.getTotalRows() > 0){
        var summaryData = summaryObj.getRecord(0);
        if(0 == summaryData.new_bind || 0 == record.new_bind_num){
            return "0%";
        }else{
            return (record.new_bind_num*100/summaryData.new_bind).toFixed(2)+"%";
        }
    }
}
function calc_money(record) {
    if(summaryObj && summaryObj.getTotalRows() > 0){
        var summaryData = summaryObj.getRecord(0);
        if(0 == summaryData.sum_recharge_money || 0== record.sum_money){
            return "0%";
        }else{
            return (record.sum_money*100/summaryData.sum_recharge_money).toFixed(2)+"%";
        }
    }
}
function calc_num(record) {
    if(summaryObj && summaryObj.getTotalRows() > 0){
        var summaryData = summaryObj.getRecord(0);
        if(0 == summaryData.sum_recharge_num || 0 == record.sum_recharge_num){
            return "0%";
        }else{
            return (record.sum_recharge_num*100/summaryData.sum_recharge_num).toFixed(2)+"%";
        }
    }
}

function calc_sum_bind_register(record) {
    if(0 >= record.new_num || 0 == record.new_bind){
        return "0%";
    }else{
        return (record.new_bind*100/record.new_num).toFixed(2)+"%";
    }
}
function calc_sum_bind_act(record) {
    if(0 >= record.avg_act_num || 0 == record.avg_bind_num){
        return "0%";
    }else{
        return (record.avg_bind_num*100/record.avg_act_num).toFixed(2)+"%";
    }
}
function calc_sum_bind(record) {
    if(0 >= record.sum_register || 0 == record.sum_bind_register){
        return "0%";
    }else{
        return (record.sum_bind_register*100/record.sum_register).toFixed(2)+"%";
    }
}
var summaryObj = null;

layui.use(['form', 'laydate'], function(){
    var form = layui.form();

    var laydate = layui.laydate;

    var start = {
        max:laydate.now(),
        format: 'YYYY-MM-DD',
        choose: function(datas){
            end.min = datas; //开始日选好后，重置结束日的最小日期
            end.start = datas //将结束日的初始值设定为开始日
        }
    };

    var end = {
        max:laydate.now(),
        format: 'YYYY-MM-DD',
        choose: function(datas){
            start.max = datas; //结束日选好后，重置开始日的最大日期
        }
    };

    $('#range_s').on('click', function(){
        start.elem = this;
        laydate(start);
    });

    $('#range_e').on('click', function(){
        end.elem = this
        laydate(end);
    });

    //监听提交
    form.on('submit(query)', function(data){
        $('#summaryTable').show();
        if (!summaryObj)
        {
            summaryObj = $.fn.bsgrid.init('summaryTable', {
                url: 'index.php?/game/detail/summary/',
                dataType: 'json',
                pageSize: 1,
                stripeRows:true,//隔行换色
                rowHoverColor:true,// 划过行变色
                displayBlankRows:false,//是否显示空白行,
                pageSizeSelect:false,
                showPageToolbar:false,
                otherParames:data.field,
            });
            $('.layui-label').show();
        }
        else
        {
            summaryObj.search(data.field);
        }
        return false;
    });
});
$(document).ready(function () {
    $('.layui-icon').click(function(){
        var msg = $(this).parent().data('tip');
        layer.tips(msg, $(this), {
            time: 6000,
            tips: [4, '#78BA32']
        });
    });
});

