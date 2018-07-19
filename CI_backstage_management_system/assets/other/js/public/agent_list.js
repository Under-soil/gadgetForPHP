var levels = $('#levels').val();
var area_level = 0;
var operator_level = 100;
if(levels >= 100)
{
    $("#level").find("option[value='0']").attr("selected", true);
    $("#level").find("option[value='1']").attr("disabled","disabled");
    $("#level").find("option[value='2']").attr("disabled","disabled");
    $("#level").find("option[value='3']").attr("disabled", "disabled");
    $('#item-code').show();
    $('#item-code>label').text('区域经理ID');
    $("#item-pcode").show();
}else if(levels == 2)
{
    $("#level").find("option[value='0']").attr("disabled","disabled");
    $("#level").find("option[value='1']").attr("disabled","disabled");
    $("#level").find("option[value='2']").attr("disabled","disabled");
    $("#level").find("option[value='3']").attr("selected", true);
    $('#item-code>label').text('邀请码');
    //$("#item-pcode").show();
}else if(levels == 1)
{
    $("#level").find("option[value='0']").attr("disabled","disabled");
    $("#level").find("option[value='1']").attr("disabled","disabled");
    $("#level").find("option[value='2']").attr("selected",true);
    $('#item-code>label').text('邀请码');
    //$("#item-pcode").show();
}else if(levels == 0)
{
    $("#level").find("option[value='0']").attr("disabled","disabled");
    $("#level").find("option[value='1']").attr("selected",true);
    $('#item-code>label').text('邀请码');
    $("#item-pcode").hide();
}

$('#btn-showlist').hide();
var gridObj;
$(function () {
    gridObj = $.fn.bsgrid.init('searchTable', {
        url: 'index.php?/agent/agent_list/data/',
        dataType: 'json',
        pageSize: 20,
        stripeRows:true,//隔行换色
        rowHoverColor:true,// 划过行变色
        displayBlankRows:false,//是否显示空白行,
        pageSizeSelect:false,
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
    var level = levels;
    if (record.state != 1)
    {
        opt.push('<a href="javascript:setstate( 1, '+record.uid+');"  >启用</a> | ');
    }
    else
    {
        opt.push('<a href="javascript:setstate( 0, '+record.uid+');"  >禁用</a> | ');
    }
    opt.push('<a href="javascript:setting('+rowIndex+');"  >设置</a>');
    if(levels >= operator_level || levels == area_level){
        opt.push(' | <a href="javascript:resetpwd('+record.uid+');"  >重置密码</a>');
    }
    return opt.join("");
}

function setstate(opt, uid){
    loading = layer.load(2, {
        shade: [0.2,'#000'] //0.2透明度的白色背景
    });

    var param = {"uid":uid, "opt":opt};
    $.post('index.php?/user/manage/setuserstate/', param, function(data){
        layer.close(loading);
        if (data.r == 4000)
        {
            gridObj.refreshPage();
            layer.closeAll('page');
        }
        else if (data.r == 1000)
        {
            top.document.location.reload();
        }
        else
        {
            layer.msg(data.m, {icon: 2, anim: 6, time: 1000});
        }
    }, "json");
}

function setting(rowIndex)
{
    var DISABLED = 'layui-btn-disabled';
    var record = gridObj.getRecord(rowIndex);
    var level = levels;

    //重置校验提示
    $('.layui-icon').remove();
    $('.tips').text('');

    $('#form-adduser')[0].reset();

    if (record.level == 0)
    {   //地区代理
        $("#item-pcode").hide();
        $("#item-code").hide();
        $("#level").find("option[value='0']").attr("selected", true);
        //   $("#level").find("option[value='0']").attr("disabled", false);
        $("#level").find("option[value='1']").attr("disabled","disabled");
        $("#level").find("option[value='2']").attr("disabled","disabled");
        $("#level").find("option[value='3']").attr("disabled", "disabled");
        //    $('#item-code>label').text('区域代理ID');
    }else if(record.level == 1){
        $("#item-pcode").hide();
        $("#level").find("option[value='1']").attr("selected", true);
        // $("#level").find("option[value='1']").attr("disabled", false);
        $("#level").find("option[value='0']").attr("disabled","disabled");
        $("#level").find("option[value='2']").attr("disabled","disabled");
        $("#level").find("option[value='3']").attr("disabled", "disabled");
        $('#item-code>label').text('邀请码');
    }else if(record.level == 2){
        $("#item-pcode").show();
        $("#level").find("option[value='2']").attr("selected", true);
        //    $("#level").find("option[value='2']").attr("disabled", false);
        $("#level").find("option[value='0']").attr("disabled","disabled");
        $("#level").find("option[value='1']").attr("disabled","disabled");
        $("#level").find("option[value='3']").attr("disabled", "disabled");
        $('#item-code>label').text('邀请码');
    } else {
        $("#item-pcode").show();
        $("#level").find("option[value='3']").attr("selected", true);
        // $("#level").find("option[value='3']").attr("disabled", false);
        $("#level").find("option[value='0']").attr("disabled","disabled");
        $("#level").find("option[value='1']").attr("disabled","disabled");
        $("#level").find("option[value='2']").attr("disabled", "disabled");
        $('#item-code>label').text('邀请码');
    }

    $("#item-passwd").hide();
    $("#item-repasswd").hide();

    $("#btn-useradd").hide();
    $("#btn-reset").hide();
    $("#btn-usersetting").addClass(DISABLED);
    $("#btn-usersetting").show();
    $('#btn-showlist').show();

    $("input[name='username']").attr("disabled",true);
    $("input[name='uid']").val(record.uid);
    $("input[name='username']").val(record.username);
    $("input[name='passwd']").val("123456");
    $("input[name='repasswd']").val("123456");

    $("input[name='realname']").val(record.realname);
    $("input[name='phone']").val(record.phone);
    $("input[name='wechat']").val(record.wechat);
    $("input[name='appuid']").val(record.appuid);

    $("input[name='code']").val(record.code);
    $("input[name='code']").attr("disabled",true);
    $("input[name='pcode']").val(record.pcode);
    $("#level").val(record.level);
    $("input[name='address']").val(record.address);
    $('input[name=row-index]').val(rowIndex);

    $('#page-user').hide();
    $('#layer-adduser').show();
    $('.search_form').hide();
    checkAppuid();
    if($('#pcode').is(':visible')){
        checkPCode();
    }
    setTimeout(function () {
        $('#btn-usersetting').removeClass(DISABLED);
    }, 3000);



}

function resetpwd(uid)
{
    loading = layer.load(2, {
        shade: [0.2,'#000'] //0.2透明度的白色背景
    });

    var param = {"uid":uid};
    $.post('index.php?/user/manage/pwdreset/', param, function(data){
        layer.close(loading);
        if (data.r == 4000)
        {
            layer.msg("重置成功");
        }
        else if (data.r == 1000)
        {
            window.top.location.reload();
        }
        else
        {
            layer.msg("重置失败", {icon: 2, anim: 6, time: 1000});
        }
    }, "json");

}
function validation(id, type, url, param) {
    $.ajax({
        type: type,
        url: url,
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
            }else{
                $('#'+id).attr('position', 'relative');
                if($('#'+id).next().length > 0){
                    $('#'+id).next().remove();
                    $("#"+id).after('<i class="layui-icon" style="font-size: 15px; color: green; position:absolute;right:5px;top:10px" data-flag="ok">&#xe618;</i>');
                }else{
                    $("#"+id).after('<i class="layui-icon" style="font-size: 15px; color: green; position:absolute;right:5px;top:10px" data-flag="ok">&#xe618;</i>');
                }
                $('.tips').text('');
            }
        }
    });
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
            data:$("#appuid").val(),
            username:$("#username").val(),
        };
    return validation(id, type, url, param);
}
function checkCode() {
    var data  = $("#code").val();

    if(data.length != 5){
        return false;
    }
    if( /^0+/.test(data))
    {
        $('.tips').text('邀请码不能以0开头');
        $('.layui-icon').remove();
        $('#'+id).attr('position', 'relative');
        $("#"+id).after('<i class="layui-icon" style="font-size: 15px; color: red; position:absolute;right:5px;top:10px">&#x1006;</i>');
        return false;
    }
    var id = 'code',
        type = 'POST',
        url = "index.php?/user/manage/isCodeExists",
        param = {
            data:$("#code").val(),
            username:$("#username").val(),
        };
    validation(id, type, url, param);
}
function checkPCode() {
    var data  = $("#pcode").val();
    if(data.length != 5){
        return false;
    }
    var id = 'pcode',
        type = 'POST',
        url = "index.php?/user/manage/isPCodeExists",
        param = {
            data:$("#pcode").val(),
            level:$('#level option:selected') .val(),
            username:$("#username").val(),
        };
    validation(id, type, url, param);
}




$("#appuid").blur(function(){
    checkAppuid();
});

$("#code").blur(function(){
    checkCode();
});

$("#pcode").blur(function(){
    checkPCode();
});

layui.use(['form', 'layer'], function(){
    var form = layui.form();
    var $ = layui.jquery;
    form.render();

    form.on('select(level)', function(data) {
        var level = data.value;
        if (level == 1 || level == 0)
        {
            $("#item-pcode").hide();
        }
        else
        {
            $("#item-pcode").show();
        }
        var user_level = levels;
        if(user_level + 1 == level){
            $("#item-pcode").hide();
        }
    });
    form.on('select(appuid)', function(data){
        if ( /^\d{8}$/.test(data.value) == false)
        {
            return "游戏用户ID为8位数字";
        }
    });
    form.on('select(code)', function(data){
        var user_level = levels;
        var level = $('#level option:selected') .val();
        if(user_level == 0){
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
        var user_level = levels;
        var level = $('#level option:selected') .val();
        if(user_level == 0){
            if((user_level != level-1)){
                if (/^\d{5}$/.test(data.value) == false)
                {
                    return "上级邀请码为5位数字";
                }
            }
        }
    });

    //显示列表 显示
    $("#btn-showlist").on('click', function() {
        $('#page-user').show();
        $('#btn-showlist').hide();
        $('#layer-adduser').hide();
        $('.search_form').show();
    });

    //用户新增 验证
    form.verify({
        //验证可以有两种方法，一种if，一种直接判断
        repasswd:function(value){
            if (value != $('#passwd').val())
            {
                return '密码和确认密码不一致';
            }
        },
        search_code:function(value){
            var user_level = levels;
            if(user_level == 0){
                if ( (value!= "") && ( /^\d{5}$/.test(value) == false))
                {
                    return "邀请码为5位数字";
                }
            }else{
                if ( (value!= "") && (( /^\d{4}$/.test(value) == false) && ( /^\d{5}$/.test(value) == false)))
                {
                    return "区域经理ID为8位数字,邀请码为5位数字";
                }
            }

        },
        search_realname:function(value){
            if ((value!= "") && (/^([\u4e00-\u9fa5]+|([a-zA-Z]+\s?)+)$/.test(value) == false))
            {
                return "请填写正确真实姓名";
            }
        },
        search_appuid:function (value) {
            if((value.length>0) && (/^\d{8}$/.test(value) == false)){
                return "游戏用户ID为8位数字";
            }
        },
        area_code:function (value) {
            if((value.length>0) && (/^\d{4}$/.test(value) == false)){
                return "区域ID为4位数字";
            }
        }
    });


    form.on('submit(usersetting)', function(data) {
        if(!($('#appuid').next().length > 0 && 'ok' == $('#appuid').next().data('flag')) ){
            return false;
        }
        if($('#pcode').is(':visible')){
            if(!($('#pcode').next().length > 0 && 'ok' == $('#pcode').next().data('flag')) ){
                return false;
            }
        }
        layer.load(2);
        setTimeout(function(){
            layer.closeAll('loading');
        }, 3000);
        setTimeout(function () {
            if($('.tips').text().length > 0){
                return false;
            }
            loading = layer.load(2, {
                shade: [0.2,'#000'] //0.2透明度的白色背景
            });
            var param = data.field;
            var rowIndex = $('input[name=row-index]').val();
            var record = gridObj.getRecord(rowIndex);
            if (record.phone != param.phone)
            {
                if (!new RegExp(/^(13[0-9]|14[579]|15[0-3,5-9]|16[6]|17[0135678]|18[0-9]|19[89])\d{8}$/).test(param.phone))
                {
                    delete param.phone;
                }
            } else {
                delete param.phone;
            }
            if (record.wechat != param.wechat)
            {
                if (!new RegExp(/^[a-zA-Z1-9]{1}[-_a-zA-Z0-9]{5,19}$/).test(param.wechat))
                {
                    delete param.wechat;
                }
            } else {
                delete param.wechat;
            }
            $.post('index.php?/user/manage/useredit/', param, function(data){
                layer.close(loading);
                if (data.r == 4000)
                {
                    layer.msg('修改成功', {icon: 1, anim: 6, time: 1000});
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
        }, 3000);
    });

    //监听提交
    form.on('submit(query)', function(data){
        gridObj.search(data.field);
        return false;
    });

});

