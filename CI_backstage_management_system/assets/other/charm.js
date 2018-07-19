layui.define(['form','jquery'],function(exports){
    var form = layui.form();
    var $ = layui.jquery;
    var obj = {
        //游戏ID
        appuid:function (value) {
            if((value.length>=0) && (/^\d{8}$/.test(value) == false)){
                layer.msg("游戏用户ID为8位数字", {icon: 2, anim: 6, time: 1000});
                return false;
            }
        },
        //用户名
        username: function(value) {
            if ( /^[0-9a-zA-Z\u4e00-\u9fa5][0-9a-zA-Z_@.\u4e00-\u9fa5]{0,18}[0-9a-zA-Z\u4e00-\u9fa5]$/.test(value) == false)
            {
                layer.msg("用户名格式不正确", {icon: 2, anim: 6, time: 1000});
                return false;
            }
        },
        //密码
        passwd: function (value) {
            if ( /(?!^\[0-9]+$)(?!^[a-zA-Z]+$)(?!^[_#@]+$).{6,20}/.test(value) == false)
            {
                layer.msg("密码必须6到20位", {icon: 2, anim: 6, time: 1000});
                return false;
            }
            if(/(\s+)/.test(value) == true){
                layer.msg("密码不能包含空格", {icon: 2, anim: 6, time: 1000});
                return false;
            }
        },
        //真实姓名
        realname:function(value){
            if ((value.length>=0) && (/^([\u4e00-\u9fa5]+|([a-zA-Z]+\s?)+)$/.test(value) == false))
            {
                layer.msg("请填写正确真实姓名", {icon: 2, anim: 6, time: 1000});
                return false;
            }
        },
        //邀请码
        code:function(value){
            if ( (value.length>=0) && ( /^\d{5}$/.test(value) == false))
            {
                layer.msg("邀请码为5位数字,区域ID为4位数字", {icon: 2, anim: 6, time: 1000});
                return false;
            }
            if( /^0+/.test(value)){
                layer.msg("邀请码不能以0开头", {icon: 2, anim: 6, time: 1000});
                return false;
            }
        },
        //返佣者邀请码
        f_code:function(value){
            if(value.length > 0){
                if ( /^\d{5}$/.test(value) == false)
                {
                    layer.msg("返佣者邀请码为5位数字", {icon: 2, anim: 6, time: 1000});
                    return false;
                }
                if( /^0+/.test(value)){
                    layer.msg("返佣者邀请码不能以0开头", {icon: 2, anim: 6, time: 1000});
                    return false;
                }
            }
        },
        //区域ID
        area_code:function (value) {
            if((value.length>0) && (/^\d{4}$/.test(value) == false)){
                layer.msg("区域ID为4位数字", {icon: 2, anim: 6, time: 1000});
                return false;
            }
        },
        //验证码
        captcha: function (value) {
            if(/^\d{4}$/.test(value) == false){
                layer.msg("验证码格式不正确", {icon: 2, anim: 6, time: 1000});
                return false;
            }
        },
        //手机号
        phone: function(value) {
            if(!new RegExp(/^(13[0-9]|14[579]|15[0-3,5-9]|16[6]|17[0135678]|18[0-9]|19[89])\d{8}$/).test(value)) {
                layer.msg("手机号格式不正确", {icon: 2, anim: 6, time: 1000});
                return false;
            }
        },
        //微信号
        wechat:function (value) {
            if (/^[a-zA-Z1-9]{1}[-_a-zA-Z0-9]{5,19}$/.test(value) == false)
            {
                layer.msg("微信号格式不正确", {icon: 2, anim: 6, time: 1000});
                return false;
            }
        },
        //QQ
        qq:function (value) {
            if (/^\d*$/.test(value) == false)
            {
                layer.msg("QQ格式不正确", {icon: 2, anim: 6, time: 1000});
                return false;
            }
        },



        
    };
    exports('charm', obj);
});

