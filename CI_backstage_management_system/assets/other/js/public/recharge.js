var gridObj = null;
layui.use(['form', 'laydate'], function () {
    var form = layui.form();

    var laydate = layui.laydate;

    var start = {
        max: laydate.now(),
        format: 'YYYY-MM-DD',
        choose: function (datas) {
            end.min = datas; //开始日选好后，重置结束日的最小日期
            end.start = datas //将结束日的初始值设定为开始日
        }
    };

    var end = {
        max: laydate.now(),
        format: 'YYYY-MM-DD',
        choose: function (datas) {
            start.max = datas; //结束日选好后，重置开始日的最大日期
        }
    };

    $('#range_s').on('click', function () {
        start.elem = this;
        laydate(start);
    });

    $('#range_e').on('click', function () {
        end.elem = this
        laydate(end);
    });

    //监听提交
    form.on('submit(query)', function (data) {
        $("#searchTable").show();
        if (!gridObj) {
            gridObj = $.fn.bsgrid.init('searchTable', {
                url: 'index.php?/game/recharge/data/',
                dataType: 'json',
                pageSize: 20,
                stripeRows: true,//隔行换色
                rowHoverColor: true,// 划过行变色
                displayBlankRows: false,//是否显示空白行,
                pageSizeSelect: false,
                showPageToolbar: false,
                otherParames: data.field,
            });
            $('.layui-label').show();
        }
        else {
            gridObj.search(data.field);
        }
        return false;
    });
});
$(document).ready(function () {
    $('.layui-icon').click(function () {
        var msg = $(this).parent().data('tip');
        layer.tips(msg, $(this), {
            time: 6000,
            tips: [4, '#78BA32']
        });
    });
});

