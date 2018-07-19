var gridObj;
$(function () {
    gridObj = $.fn.bsgrid.init('searchTable', {
        url: 'index.php?/agent/billing_details/data/',
        dataType: 'json',
        data:{
            'code':$("#code").find("option:selected").val()
        },
        pageSize: 20,
        stripeRows:true,//隔行换色
        rowHoverColor:true,// 划过行变色
        displayBlankRows:false,//是否显示空白行,
        pageSizeSelect:false,
    });
});

function level_name(record, rowIndex, colIndex, options) {
    return $('#h_group_'+record.code_level).val();
}

function remarks(record, rowIndex, colIndex, options) {
    var name =  $('#h_group_'+record.commission_level).val();
    return name+'返佣';
}

layui.use(['form', 'laydate'], function(){
    var form = layui.form();
    form.render();
    var laydate = layui.laydate;
    var start = {
        max:laydate.now(),
        istime: true,
        format: 'YYYY-MM-DD hh:mm:ss',
        choose: function(datas){
            end.min = datas; //开始日选好后，重置结束日的最小日期
            end.start = datas //将结束日的初始值设定为开始日
        }
    };

    var end = {
        max:laydate.now(),
        istime: true,
        format: 'YYYY-MM-DD hh:mm:ss',
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

    form.verify({
        f_code:function(value){
            if(value.length > 0){
                if ( /^\d{5}$/.test(value) == false)
                {
                    return "返佣者邀请码为5位数字";
                }
                if( /^0+/.test(value)){
                    return "返佣者邀请码不能以0开头";
                }
            }
        },
        area_code:function (value) {
            if((value.length>0) && (/^\d{4}$/.test(value) == false)){
                return "区域ID为4位数字";
            }
        },
        agent_code:function (value) {
            var type =  $('#type').val();
            var area_level = $('#area_level').val();
            //var level = <?php //echo AGENT_TYPE != $type ? 1 : 0; ?>//;
            var level = area_level != type ? 1 : 0;

            if(value.length > 0){
                if(level){
                    if ( /^\d{5}$/.test(value) == false && /^\d{4}$/.test(value) == false)
                    {
                        return "邀请码为5位数字,区域经理ID为4位";
                    }
                    if( /^0+/.test(value)){
                        return "邀请码不能以0开头";
                    }
                }else{
                    if ( /^\d{5}$/.test(value) == false)
                    {
                        return "邀请码为5位数字";
                    }
                    if( /^0+/.test(value)){
                        return "邀请码不能以0开头";
                    }
                }

            }
        }

    });

    //监听提交
    form.on('submit(query)', function(data){
        gridObj.search(data.field);
        return false;
    });
});

function befor_opt(record, rowIndex, colIndex, options)
{
    return (record.balance - record.commission_price).toFixed(2);
}

function total1(record, rowIndex, colIndex, options) {
    return  (record.code_level == record.commission_level) ? record.product_price : 0;
}
function total2(record, rowIndex, colIndex, options) {
    return  (record.code_level == record.commission_level) ?  0 : record.product_price;
}
function commission1(record, rowIndex, colIndex, options) {
    return  (record.code_level == record.commission_level) ? record.commission_price : 0;
}
function commission2(record, rowIndex, colIndex, options) {
    return  (record.code_level == record.commission_level) ? 0 : record.commission_price;
}

