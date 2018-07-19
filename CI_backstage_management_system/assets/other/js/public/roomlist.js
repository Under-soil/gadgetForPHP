var gridObj;
$(function () {
    gridObj = $.fn.bsgrid.init('searchTable', {
        url: 'index.php?/game/roomlist/data/',
        dataType: 'json',
        pageSize: 100,
        stripeRows: true,//隔行换色
        rowHoverColor: true,// 划过行变色
        displayBlankRows: false,//是否显示空白行,
        pageSizeSelect: false,
        otherParames:{
            "game_type":$("select[name=game_type]").children().eq(0).val()
        }
    });
});

function is_club(record) {
    if (record['club_id'] > 0) {
        return '俱乐部';
    }
    return "普通";

}
function set_state_name(record) {
    var state = ['准备','进行中','进行中'];
    return state[record['state']];
}
layui.use('form', function () {
    var form = layui.form();
    form.render();
    //监听提交
    form.on('submit(query)', function (data) {
        gridObj.search(data.field);
        return false;
    });
});
