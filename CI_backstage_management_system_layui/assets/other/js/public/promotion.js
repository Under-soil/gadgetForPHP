var levels = $('#levels').val();
var states = $('#states').val();
var area_level = $('#area_level').val();
if(levels >= 100){
    $("#level").find("option[value='0']").attr("selected", true);
    $("#level").find("option[value='1']").attr("disabled","disabled");
    $("#level").find("option[value='2']").attr("disabled","disabled");
    $("#level").find("option[value='3']").attr("disabled", "disabled");
}else if(levels == 2)
{
    $("#level").find("option[value='0']").remove();
    $("#level").find("option[value='1']").remove();
    $("#level").find("option[value='2']").remove();
    $("#level").find("option[value='3']").attr("selected", true);
    $("#item-pcode").hide();
}else if(levels == 1)
{
    $("#level").find("option[value='0']").remove();
    $("#level").find("option[value='1']").remove();
    if(2 == states)
    {
        $("#level").find("option[value='2']").remove();
        $("#level").find("option[value='3']").attr("selected",true);
        $('#level_tip').show();
    }else
    {
        $("#level").find("option[value='2']").attr("selected",true);
        $("#item-pcode").hide();
    }
}else  if(levels == 0)
{
    $("#level").find("option[value='0']").remove();
    $("#level").find("option[value='1']").attr("selected",true);
    $("#item-pcode").hide();
}

function validation(id, type, url, param) {
    $.ajax({
        type: type,
        url: url,
        data: param,
        dataType: "json",
        success: function(data){
            $('#'+id).attr('position', 'relative');
            var flag = '', icon = '',color = '';
            if(data.r == 1000){
                top.location.href="index.php";
            }
            else if(data.r == 4000){
                flag = 'ok';icon = '&#xe618;';color = 'green';
                if('pcode' == id){
                    $('#pcode_tip').text(data.m);$('#pcode_tip').hide();
                }else{
                    $('.tips').text(data.m);
                }
            }else{
                flag = 'error';icon = '&#x1006;';color = 'red';
                if('pcode' == id){
                    $('#pcode_tip').text(data.m);$('#pcode_tip').show();
                }else{
                    $('#pcode_tip').text(data.m);$('#pcode_tip').hide();
                    $('.tips').text(data.m);
                }
            }
            if($('#'+id).next().length > 0){
                $('#'+id).next().remove();
                $("#"+id).after('<i class="layui-icon" style="font-size: 15px; color: '+color+'; position:absolute;right:5px;top:10px" data-flag="'+flag+'">'+icon+'</i>');
            }else{
                $("#"+id).after('<i class="layui-icon" style="font-size: 15px; color: '+color+'; position:absolute;right:5px;top:10px" data-flag="'+flag+'" >'+icon+'</i>');
            }
        }
    });
}
function checkUserName() {
    var data  = $("#username").val();
    if(data.length < 1){
        return false;
    }
    var msg = '';

    if(/^[0-9a-zA-Z][0-9a-zA-Z_@.]{2,18}[0-9a-zA-Z]$/.test(data) == false) {
        msg =  '用户名格式错误';
    }
    if(msg.length > 0){
        $('.tips').text(msg);
        if($('#username').next().length > 0){
            $('#username').next().remove();
        }
        $('#username').attr('position', 'relative');
        $("#username").after('<i class="layui-icon" style="font-size: 15px; color: red; position:absolute;right:5px;top:10px" data-flag="error">&#x1006;</i>');
        return msg;
    }else{
        $('.tips').text('');
        if($('#username').next().length > 0){
            $('#username').next().remove();
        }
        var id = 'username',
            type = 'POST',
            url = "index.php?/user/manage/isUsernameExists",
            param = {
                data:$("#username").val()
            };
        validation(id, type, url, param);
    }
}
function checkAppuid() {
    var data  = $("#appuid").val();
    if(data.length != 8){
        return false;
    }
    var id = 'appuid',
        type = 'POST',
        url = "index.php?/user/manage/isAppUIdExists",
        param = {
            data:$("#appuid").val()
        };
    validation(id, type, url, param);
}
function checkCode() {
    var data  = $("#code").val();

    if(data.length != 5){
        return '邀请码为5为纯数字';
    }
    if( /^0+/.test(data))
    {
        $('.tips').text('邀请码不能以0开头');
        $('.layui-icon').remove();
        $('#'+id).attr('position', 'relative');
        $("#"+id).after('<i class="layui-icon" style="font-size: 15px; color: red; position:absolute;right:5px;top:10px">&#x1006;</i>');
        return '邀请码不能以0开头';
    }
    if( (!/^[0-9]{5}/.test(data)))
    {
        $('.tips').text('邀请码必须为5位纯数字');
        $('.layui-icon').remove();
        $('#'+id).attr('position', 'relative');
        $("#"+id).after('<i class="layui-icon" style="font-size: 15px; color: red; position:absolute;right:5px;top:10px">&#x1006;</i>');
        return '邀请码必须为5位纯数字';
    }
    var id = 'code',
        type = 'POST',
        url = "index.php?/user/manage/isCodeExists",
        param = {
            data:$("#code").val(),
        };
    validation(id, type, url, param);
}
function checkPCode() { //todo
    var data  = $("#pcode").val();
    if(data.length != 5){
        return '上级邀请码为5位';
    }
    var id = 'pcode',
        type = 'POST',
        url = "index.php?/user/manage/isPCodeExists",
        param = {
            data:$("#pcode").val(),
            level:$('#level option:selected') .val()
        };
    validation(id, type, url, param);
}


$("#username").blur(function(){
    checkUserName();
});

$("#appuid").blur(function(){
    checkAppuid();
});

$("#code").blur(function(){
    checkCode();
});

$("#pcode").blur(function(){
    checkPCode();
});

$('#passwd').blur(function(){
    var value = $('#passwd').val();
    var msg = '';
    if ( /(?!^\[0-9]+$)(?!^[a-zA-Z]+$)(?!^[_#@]+$).{6,20}/.test(value) == false)
    {
        msg = '密码必须6到20位';

    }
    if(/(\s+)/.test(value) == true){
        msg = '密码不能出现空格';
    }
    if(msg.length > 0){
        $('.tips').text(msg);
        if($('#passwd').next().length > 0){
            $('#passwd').next().remove();
        }
        $('#passwd').attr('position', 'relative');
        $("#passwd").after('<i class="layui-icon" style="font-size: 15px; color: red; position:absolute;right:5px;top:10px" data-flag="error">&#x1006;</i>');
        return '密码不能出现空格';
    }else{
        $('.tips').text('');
        if($('#passwd').next().length > 0){
            $('#passwd').next().remove();
        }
        $('#passwd').attr('position', 'relative');
        $("#passwd").after('<i class="layui-icon" style="font-size: 15px; color: green; position:absolute;right:5px;top:10px" data-flag="ok">&#xe618;</i>');
    }
});

layui.use(['form', 'layer'], function(){
    var form = layui.form();
    var $ = layui.jquery;
    form.render();
    form.on('select(level)', function(data) {
        var level = data.value;
        if (level == 1 || level == 0)
        {
            $("input[name=pcode]").val("");
            $("#item-pcode").hide();
        }
        else
        {
            $("#item-pcode").show();
        }
        var user_level = $('#levels').val();
        if(user_level + 1 == level){
            $("#item-pcode").hide();
        }

    });

    form.on('select(username)', function(data){
        if ( /^[0-9a-zA-Z][0-9a-zA-Z_@.]{2,18}[0-9a-zA-Z]$/.test(data) == false)
        {
            return '用户名格式不正确';
        }
    });
    form.on('select(appuid)', function(data){
        if ( /^\d{8}$/.test(data.value) == false)
        {
            return "游戏用户ID为6位数字";
        }
    });
    form.on('select(code)', function(data){
        var level = $('#level option:selected') .val();
        if(level != area_level){ //1 2 3
            if ( /^\d{5}$/.test(data.value) == false)
            {
                return "邀请码为5位数字";
            }
            if( /^0+/.test(data.value)){
                return "邀请码不能以0开头";
            }
        }
    });
    form.on('select(pcode)', function(data){
        var user_level = $('#levels').val();
        var level = $('#level option:selected') .val();
        if(user_level + 1 == level){
        }else{
            if ($('#level').val() > 1 && /^\d{5}$/.test(data.value) == false)
            {
                return "上级邀请码为5位数字";
            }
        }
    });

    //用户新增 验证
    form.verify({
        repasswd:function(value){
            if (value != $('#passwd').val())
            {
                return '密码和确认密码不一致';
            }
        },
    });
    form.on('submit(useradd)', function(data) {
        if(!($('#username').next().length > 0 && 'ok' == $('#username').next().data('flag')) ){
            return false;
        }
        if(!($('#passwd').next().length > 0 && 'ok' == $('#passwd').next().data('flag')) ){
            return false;
        }
        if(!($('#appuid').next().length > 0 && 'ok' == $('#appuid').next().data('flag')) ){
            return false;
        }
        if($('#code').is(':visible')){
            if(!($('#code').next().length > 0 && 'ok' == $('#code').next().data('flag')) ){
                return false;
            }
        }
        if($('#pcode').is(':visible')){
            if(!($('#pcode').next().length > 0 && 'ok' == $('#pcode').next().data('flag')) ){
                return false;
            }
        }

        layer.load(2);
        setTimeout(function(){
            layer.closeAll('loading');
        }, 2000);
        var param = data.field;
        $.post('index.php?/user/manage/adduser/', param, function(data){
            if (data.r == 4000)
            {
                layer.msg("添加成功", {icon: 1, anim: 6, time: 1000});
            }
            else if (data.r == 1000)
            {
                top.document.location.reload();
            }
            else
            {
                var DANGER = 'layui-form-danger';
                var name = {"2":"username", "3":"phone", "4":"wechat", "5":"appuid", "6":"appuid", "7":"code", "8":"pcode", "9":"pcode", '12':'pcode', '13':'level'};
                var ipt = $("input[name="+ name[data.r] + "]");
                $('.tips').text(data.m);
                ipt.addClass(DANGER);
                ipt.focus();
                layer.msg(data.m, {icon: 2, anim: 6, time: 1000});
            }
        }, "json");
        return false;
    });
});

$('#btn-reset').click(function () {
    $(".layui-icon").remove();
    $('.tips').text('');
});
