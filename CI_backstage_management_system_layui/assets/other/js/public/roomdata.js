layui.use(['form', 'laydate', 'layer'], function () {
    var form = layui.form();
    form.render();

    var myDate = new Date(),
        today = myDate.getFullYear() + '-' + (myDate.getMonth() + 1) + '-' + myDate.getDate();

    form.on('select(game_type)', function (data) {
        var playInfo = $('#game_type_'+data.value).data('play');
        getPlayInfo(playInfo);
    });

    function query(post) {
        $('.today').removeClass('layui-btn-primary');
        $.ajax({
            url: 'index.php?/game/roomdata/data/',
            async:false,
            type:'post',
            dataType:'html',
            data:post,
            success:function(data) {
                if(!data.match("^\{(.+:.+,*){1,}\}$"))
                {
                    $('#tbody').html(data);
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
        $('#data').show();
    }

    form.on('select(play_rule)', function (data) {
        var post = {
            play_rule:data.value,
        };
        query(post);
    });

    $(document).ready(function () {
        $('.layui-icon').click(function () {
            var msg = $(this).parent().data('tip');
            layer.tips(msg, $(this).parent().next(), {
                tips: [4, '#78BA32']
            });
        });

        query({play_rule:0});
    });

});


