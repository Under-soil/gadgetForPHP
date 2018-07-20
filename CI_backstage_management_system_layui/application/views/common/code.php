<style>
    #login_container{
        width:300px;
        padding-top:100px;
        margin: 0 auto;
    }
    p{
        text-align: center;
    }
    .wx_tip{
        color: red;
        line-height: 3;
        font-size: 16px;
    }
    .wx_tip > img{
        width: 16px;
        height: 16px;
    }
    .lay-wechat{
        width: 70%;
        margin: 0 auto;
    }
    .lay-wechat a{
        padding: 8px;
    }
</style>

<div id="login_container"></div>
<?php if('wechat' == $type){ ?>
    <p class="wx_tip"><img src="../ams/assets/other/images/tips.png" />微信绑定，请将您在本系统取款时使用的微信号与本帐号绑定，一旦绑定，微信取款的款项将转账到该微信号。</p>
    <div class="lay-wechat">
        <a href="<?php echo $url; ?>"><button class="layui-btn">继续绑定</button></a>
        <a href="index.php?/user/manage/logout/"><button class="layui-btn layui-btn-danger">退&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;出</button></a>
    </div>
    <!-- 确认 直接跳转 取消按钮 退出登录 -->
<?php }else{ ?>
    <p>请使用微信扫描二维码</p>
    <p><img src="<?php echo $src; ?>"></p>
    <?php if('phone' == $type){ ?>
        <p class="wx_tip"><img src="../ams/assets/other/images/tips.png" />请将本系统的网址分享到微信中或在电脑上登录，或者使用另一台手机登录，再使用微信进行扫码。</p>
        <?php }else{ ?>
        <p class="wx_tip"><img src="../ams/assets/other/images/tips.png" />微信绑定，请将您在本系统取款时使用的微信扫描二维码，扫描成功后该微信号与本帐号绑定，一旦绑定，微信取款的款项将转账到该微信号。</p>
        <?php } ?>
<?php } ?>
<script>
    var renovate = <?php echo $renovate; ?>;
    if(1 == renovate){
        var t = window.setInterval(function(){
            if(1 == renovate){
                $.ajax({
                    type: 'post',
                    url: 'index.php?/main/connect/',
                    data: {},
                    dataType: "json",
                    success: function(result){
                        if(result.r == 2){
                            renovate = 0;
                        }else if(result.r == 1 || result.r == 1000){
                            top.location.href="index.php?/main";
                        }
                    }
                });
            }
        },10000);
    }
</script>
