var gridObj;
$(function () {
    gridObj = $.fn.bsgrid.init('searchTable', {
        url: 'index.php?/user/operate/data/',
        dataType: 'json',
        pageSize: 20,
        stripeRows:true,//隔行换色
        rowHoverColor:true,// 划过行变色
        displayBlankRows:false,//是否显示空白行,
        pageSizeSelect:false,
    });
});

function change_item(record){
    switch (record['change_item']){
        case 'username':
            return '用户名';
            break;
        case 'passwd':
            return '密码修改';
            break;
        case 'passwd_reset':
            return '密码重置';
            break;
        case 'realname':
            return '姓名';
            break;
        case 'phone' :
            return "手机号";
            break;
        case 'wechat' :
            return "微信";
            break;
        case 'appuid':
            return '游戏用户ID';
            break ;
        case 'level':
            return '推广员级别';
            break;
        case 'code':
            return '邀请码';
            break;
        case 'pcode' :
            return "上级邀请码";
            break;
        case 'address':
            return "所在地区";
            break;
        case 'area_code':
            return '区域编码';
            break;
        case 'state' :
            return '禁用状态';
            break;
    }
}

function level_name(record, rowIndex, colIndex, options) {
    return $('#h_group_'+record.level).val();
}

function operate_level(record, rowIndex, colIndex, options) {
    return $('#h_group_'+record.operate_level).val();
}

function original_content(record){
    if('passwd' == record['change_item']){
        return "*";
    }
    if('state' == record['change_item']){
        return record['original_content'] == 1?"否":"是";
    }
    if('level' == record['change_item']){
        return $('#h_group_'+record.original_content).val();
    }
    return record['original_content'];
}

function new_content(record){
    if('passwd' == record['change_item']){
        return "*";
    }
    if('state' == record['change_item']){
        return record['new_content'] == 1?"否":"是";
    }
    if('level' == record['change_item']){
        return $('#h_group_'+record.new_content).val();
    }

    return record['new_content'];
}
layui.use(['form'], function(){
    var form = layui.form();
    form.render();

    //用户新增 验证
    form.verify({
        realname:function(value){
            if ((value!= "") && (/^([\u4e00-\u9fa5]+|([a-zA-Z]+\s?)+)$/.test(value) == false))
            {
                return "请填写正确真实姓名";
            }
        },
        code:function (value) {
            if($('input[name=code]').attr('placeholder') == '邀请码'){
                if ( (value!= "") && ( /^\d{5}$/.test(value) == false)) {
                    return "邀请码为5位数字";
                }
            }else{
                if ( (value!= "") && (( /^\d{4}$/.test(value) == false) && ( /^\d{5}$/.test(value) == false))) {
                    return "区域经理ID为4位数字,邀请码为5位数字";
                }
            }
        },
        appuid:function (value) {
            if((value.length>0) && (/^\d{8}$/.test(value) == false)){
                return "游戏用户ID为8位数字";
            }
        }
    });
    //监听提交
    form.on('submit(query)', function(data){
        gridObj.search(data.field);
        return false;
    });
});
