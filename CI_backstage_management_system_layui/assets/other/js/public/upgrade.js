$('#btn-showlist').hide();
var gridObj;
$(function () {
    gridObj = $.fn.bsgrid.init('searchTable', {
        url: 'index.php?/user/upgrade/data/',
        dataType: 'json',
        pageSize: 20,
        stripeRows:true,//隔行换色
        rowHoverColor:true,// 划过行变色
        displayBlankRows:false,//是否显示空白行,
        pageSizeSelect:false,
    });
});

//显示列表 显示
$("#btn-showlist").on('click', function() {
    $('#page-user').show();
    $('#btn-showlist').hide();
    $('#layer-adduser').hide();
    $('.search_form').show();
});

$('#pcode').blur(function(){
    var DISABLED = 'layui-btn-disabled';
    var pcode = $("#pcode").val();
    var id = 'pcode',
        param = {
            pcode:pcode,
            uid:$("input[name='uid']").val(),
        };
    if(/^\d{5}$/.test(pcode) == false){
        return false;
    }
    $.ajax({
        type: 'POST',
        url: "index.php?/user/upgrade/isPCodeExists",
        data: param,
        dataType: "json",
        success: function(data){
            if(data.r == 4000){
                $('.tips').text(data.m);
                $('#'+id).attr('position', 'relative');
                if($('#'+id).next().length > 0){
                    $('#'+id).next().remove();
                    $("#"+id).after('<i class="layui-icon" style="font-size: 15px; color: red; position:absolute;right:5px;top:10px" data-flag="error">&#x1006;</i>');
                }else{
                    $("#"+id).after('<i class="layui-icon" style="font-size: 15px; color: red; position:absolute;right:5px;top:10px" data-flag="error" >&#x1006;</i>');
                }
                $("#btn-usersetting").addClass(DISABLED);
            }else{
                $('#'+id).attr('position', 'relative');
                if($('#'+id).next().length > 0){
                    $('#'+id).next().remove();
                    $("#"+id).after('<i class="layui-icon" style="font-size: 15px; color: green; position:absolute;right:5px;top:10px" data-flag="ok">&#xe618;</i>');
                }else{
                    $("#"+id).after('<i class="layui-icon" style="font-size: 15px; color: green; position:absolute;right:5px;top:10px" data-flag="ok">&#xe618;</i>');
                }
                $('.tips').text('');
                $("#btn-usersetting").removeClass(DISABLED);
            }
        }
    });
});

function level_name(record, rowIndex, colIndex, options) {
    return $('#h_group_'+record.level).val();
}

function state_name(record, rowIndex, colIndex, options) {
    if (record.state == 1)
    {
        return '正常';
    }
    return '禁用';
}

function operate(record, rowIndex, colIndex, options) {
    var opt = [];
    opt.push('<a href="javascript:setting( '+rowIndex+');"  >升级</a>');
    return opt.join("");
}

function setting(rowIndex)
{
    var DISABLED = 'layui-btn-disabled';
    var record = gridObj.getRecord(rowIndex);

    //重置校验提示
    $('.layui-icon').remove();
    $('.tips').text('');

    $('#form-adduser')[0].reset();

    $("#btn-usersetting").addClass(DISABLED);
    $("#btn-usersetting").show();
    $('#btn-showlist').show();

    $("input[name='code']").val(record.code);
    $("input[name='uid']").val(record.uid);

    $('#page-user').hide();
    $('#layer-adduser').show();
    $('.search_form').hide();
}

layui.use(['form','layer'], function(){
    var form = layui.form();
    form.render();
    form.on('select(appuid)', function(data){
        if ( /^\d{8}$/.test(data.value) == false) return "游戏用户ID为8位数字";
    });
    form.on('select(code)', function(data){
        if ( /^\d{5}$/.test(data.value) == false) return "邀请码为5位数字";
    });
    //用户新增 验证
    form.verify({
        search_code:function(value){
            if ( (value!= "") && ( /^\d{5}$/.test(value) == false)) return "邀请码为5位数字";

        },
        search_realname:function(value){
            if ((value!= "") && (/^([\u4e00-\u9fa5]+|([a-zA-Z]+\s?)+)$/.test(value) == false)) return "请填写正确真实姓名";
        },
        search_appuid:function (value) {
            if((value.length>0) && (/^\d{8}$/.test(value) == false)) return "游戏用户ID为8位数字";
        }
    });
    form.on('submit(usersetting)', function(data) {
        layer.load(2);
        var param = data.field;
        $.post('index.php?/user/upgrade/update/', param, function(data){
            layer.closeAll('loading');
            if (data.r == 4000)
            {
                layer.msg('升级成功', {icon: 1, anim: 6, time: 1000});
                gridObj.refreshPage();
                $('#layer-adduser').hide();
                $('#btn-showlist').hide();
                $('#page-user').show();
                $('.search_form').show();

            }
            else if (data.r == 1000)
            {

                window.top.location.reload();
            }
            else
            {
                layer.msg(data.m, {icon: 2, anim: 6, time: 1000});
            }
        }, "json");
        return false;
    });

    //监听提交
    form.on('submit(query)', function(data){
        gridObj.search(data.field);
        return false;
    });



});
