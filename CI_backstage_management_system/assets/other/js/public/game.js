$(function () {
    index();
});
// 添加游戏
function add(){
    var url = 'index.php?/dev/game/create';
    html(url);
}

// 游戏列表
function index(){
    var url = 'index.php?/dev/game/table';
    html(url);
}

function html(url) {
    $.ajax({
        url: url,
        async:false,
        type:'post',
        dataType:'html',
        success:function(data) {
            if(!data.match("^\{(.+:.+,*){1,}\}$"))
            {
                $('.tabbable').html(data);
            } else {
                var obj = eval('(' + data + ')');
                if (obj.r == 1000)
                {
                    window.top.location.reload();
                } else
                {
                    bootbox.alert(obj.m);
                }
            }
        }
    });
}


