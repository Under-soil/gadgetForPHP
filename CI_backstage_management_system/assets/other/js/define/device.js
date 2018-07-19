function jsUse(jsPath) {
    if(jsPath) document.write('<script src="'+jsPath+'"/>');
}
function cssUse(cssPath) {
    if(cssPath) document.write('<link rel="stylesheet" href="'+cssPath+'"/>');
}

function cssChange(){
    var link = document.getElementsByTagName('link')[0];
    //PC端应用的样式文件：style_A.css
    alert('当前应用样式文件是：'+link.getAttribute('href'));
    link.setAttribute('href','style_B.css');
    //Mobile端应用样式文件：style_B.css
    alert('当前应用样式文件是：'+link.getAttribute('href'));
}

function mobileInit() {
    //pc网站初始化
    $("#body-content").addClass('layui-body-content');
    if($("#body-content").hasClass('layui-body')) $("#body-content").removeClass('layui-body');

}
function webInit() {
    //网站初始化
    $("#body-content").addClass('layui-body');
    if($("#body-content").hasClass('layui-body-content')) $("#body-content").removeClass('layui-body-content');
    $("#btn-toggle").hide();
}


function device() {
    var browser={
        versions:function(){
            var u = navigator.userAgent, app = navigator.appVersion;
            //移动设备浏览器版本信息
            return {
                //IE内核
                trident: u.indexOf('Trident') > -1,
                //opera内核
                presto: u.indexOf('Presto') > -1,
                //苹果、谷歌内核
                webKit: u.indexOf('AppleWebKit') > -1,
                //火狐内核
                gecko: u.indexOf('Gecko') > -1 && u.indexOf('KHTML') == -1,
                //是否为移动终端
                mobile: !!u.match(/AppleWebKit.*Mobile.*/),
                //ios终端
                ios: !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/),
                //android终端或者uc浏览器
                android: u.indexOf('Android') > -1 || u.indexOf('Linux') > -1,
                //是否为iPhone或者QQHD浏览器
                iPhone: u.indexOf('iPhone') > -1 ,
                //是否iPad
                iPad: u.indexOf('iPad') > -1,
                //是否web应该程序，没有头部与底部
                webApp: u.indexOf('Safari') == -1
            };
        }(),
        language:(navigator.browserLanguage || navigator.language).toLowerCase()
    }

    if(browser.versions.mobile || browser.versions.ios || browser.versions.android || browser.versions.iPhone || browser.versions.iPad){
        mobileInit();
        //cssUse();
        //jsUse();
    }else{
        webInit();
    }
}

