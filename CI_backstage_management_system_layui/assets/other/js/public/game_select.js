layui.use(['form', 'laydate', 'layer'], function () {
    var form = layui.form();
    form.render();

    form.on('select(game_type)', function (data) {
        var playInfo = $('#game_type_'+data.value).data('play');
        showData(playInfo);
        if (data.value > 0)
        {
            $('#btn-add').show();
        } else {
            $('#btn-add').hide();
        }
    });

    //监听提交
    form.on('submit(submit)', function(data){
        loading = layer.load(2, {
            shade: [0.2,'#000'] //0.2透明度的白色背景
        });
        //获取选择的游戏
        var gameType = $('select[name="game_type"]').find("option:selected").val();
        var playInfo = $('#game_type_'+gameType).data('play');
        //获取tr里面的id和name
        var data = index = name = '';
        if (playInfo){
            jQuery.each($('#content tr'),function(i, val){
                index = $(this).children().eq(0).html();
                name = $(this).children().eq(1).html();
                data += index+'='+name+'&';
            });
        }
        //添加上新增部分
        var newId = $('#add input[name=index]').val();
        var newName = $('#add input[name=name]').val();
        data += newId+'='+newName;
        var postData = {id:gameType, data:data};
        var type = 'add';
        if ($('#add input[name=index]').attr("readonly"))
        {
            type = 'edit';
        }
        postData.type = type;
        post(postData);
        return false;
    });

    //监听提交
    form.on('submit(add)', function(data){
        //获取选择的游戏
        var gameType = $('select[name="game_type"]').find("option:selected").val();

        //弹出新增页面
        $('#myModalLabel').text('添加');
        $('#add_id').val(gameType);
        $('#add input[name=index]').val('');
        $('#add input[name=index]').removeAttr("readonly");
        $('#add input[name=name]').val('');
        $('#form-add').modal('show');
        return false;
    });

    /*
    检查id是否为数字
    检查id是否已经被占用
    检查name是否为2-10个汉字
     */
    form.verify({
        index: function(value, item){ //value：表单的值、item：表单的DOM对象
            if(value.length <= 0)
            {
                return '下拉值不能为空';
            }
            if(!new RegExp("^[1-9]{1}[0-9]*$").test(value)){
                return '下拉值格式不正确';
            }
            if(value <= 0)
            {
                return '下拉值为正整数';
            }
            if (!$('#add input[name=index]').attr("readonly"))
            {
                if ($('#tr_'+value).length > 0)
                {
                    return '下拉值已使用';
                }
            }


        },
        name:function(value, item){
            if(value.length <= 0)
            {
                return '下拉选项不能为空';
            }
            if(!new RegExp("^[\u4e00-\u9fa5]{2,5}$").test(value)){
                return '下拉选项仅支持2-5位汉字';
            }
        }
    });



    function showData(data) {
        var html = '';
        if (data) {
            jQuery.each(data, function (i, val) {
                html += '<tr id="tr_'+i+'" ><td style="text-align: center;" class="lineNoWrap">'+i+'</td><td style="text-align: center;" class="lineNoWrap">'+val.name+'</td><td style="text-align: left;" class="lineNoWrap"><a href="javascript:;"  onclick="edit('+i+')">修改</a> | <a href="javascript:;" onclick="del('+i+');">删除</a></td></tr>';
            });
        } else {
            html += '<tr id="empty"><td colspan="3" class="text-center">暂无数据</td></tr>';
        }
        $('#content').html(html);
    }




});
function del(id) {
    loading = layer.load(2, {
        shade: [0.2,'#000'] //0.2透明度的白色背景
    });
    var gameType = $('select[name="game_type"]').find("option:selected").val();
    var playInfo = $('#game_type_'+gameType).data('play');
    var data = '';
    jQuery.each(playInfo, function (i, val) {
        if (i != id)
        {
            data += i+'='+val.name+'&';
        }
    });
    data = data.substr(0,data.length-1);
    post({id:gameType, data:data, index:id, type:'del'});
}

function edit(id){
    //获取选择的游戏
    var gameType = $('select[name="game_type"]').find("option:selected").val();
    //弹出新增页面
    $('#myModalLabel').text('编辑');
    $('#add_id').val(gameType);
    $('#add input[name=index]').val(id);
    $('#add input[name=index]').attr("readonly","readonly");
    $('#add input[name=name]').val($('#tr_'+id).children().eq(1).text());
    $('#form-add').modal('show');
}

function post(postData) {
    $.ajax({
        url: 'index.php?/dev/game/saveDrop/',
        async:false,
        type:'post',
        dataType:'json',
        data:postData,
        success:function(data) {
            layer.close(loading);
            if (data.r == 4000)
            {
                var play = '';
                if (data.m.length > 0){
                    play = $.parseJSON(data.m);
                }
                var id = postData.id;
                $('#game_type_'+id).data('play', play);
                if (postData.type == 'del') {
                    $('#tr_'+postData.index).remove();
                    layer.msg('删除成功', {icon: 1, anim: 6, time: 1000});
                } else if(postData.type == 'add'){
                    var newId = $('#add input[name=index]').val();
                    var newName = $('#add input[name=name]').val();
                    var html = '<tr id="tr_'+newId+'" ><td style="text-align: center;" class="lineNoWrap">'+newId+'</td><td style="text-align: center;" class="lineNoWrap">'+newName+'</td><td style="text-align: left;" class="lineNoWrap"><a href="javascript:;"  onclick="edit('+newId+')">修改</a> | <a href="javascript:;" onclick="del('+newId+');">删除</a></td></tr>';
                    $('#content').children().last().after(html);
                    if ($('#empty').length > 0) {
                        $('#empty').remove();
                    }
                    $('#form-add').modal('hide');
                    layer.msg('添加成功', {icon: 1, anim: 6, time: 1000});
                } else if(postData.type == 'edit'){
                    var newId = $('#add input[name=index]').val();
                    var newName = $('#add input[name=name]').val();
                    $('#tr_'+newId).children().eq(1).text(newName);
                    $('#form-add').modal('hide');
                    layer.msg('编辑成功', {icon: 1, anim: 6, time: 1000});
                }
            } else {
                layer.msg(data.m, {icon: 2, anim: 6, time: 1000});
            }
        }
    });
}
