var gridObj = null;
layui.use(['form', 'laydate'], function () {
    var form = layui.form();

    var laydate = layui.laydate;

    var start = {
        max: laydate.now(),
        istime: true,
        format: 'YYYY-MM-DD hh:mm:ss',
        choose: function (datas) {
            end.min = datas; //开始日选好后，重置结束日的最小日期
            end.start = datas //将结束日的初始值设定为开始日
        }
    };

    var end = {
        max: laydate.now(),
        istime: true,
        format: 'YYYY-MM-DD hh:mm:ss',
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
                url: 'index.php?/game/room/data/',
                dataType: 'json',
                pageSize: 20,
                stripeRows: true,//隔行换色
                rowHoverColor: true,// 划过行变色
                displayBlankRows: false,//是否显示空白行,
                pageSizeSelect: false,
                otherParames: data.field,
            });
        }
        else {
            gridObj.search(data.field);
        }

        return false;
    });
});

