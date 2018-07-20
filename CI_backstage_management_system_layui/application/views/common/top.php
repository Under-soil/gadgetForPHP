<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<style>
    #tips {
        margin: 2px 20px;
    }
    #tips span {
        float: left;
        width: 50px;
        height: 20px;
        color: white;
        background: white;
        margin-right: 2px;
        line-height: 20px;
        text-align: center;
    }
    #layer-reset-pwd .layui-form{
        padding: 10px;
    }
    #layer-reset-pwd .layui-input{
        width: 150px;
    }
    #layer-reset-pwd .layui-form-label{
        width: 90px;
        padding: 9px 10px;
    }

</style>
<body>
<div class="navbar navbar-default" id="navbar">
    <script type="text/javascript">
        try {
            ace.settings.check('navbar', 'fixed')
        } catch (e) {
        }
    </script>
    <div class="navbar-container" id="navbar-container"><a class="menu-toggler" id="menu-toggler" href="#"><span class="menu-text"></span></a>
        <div class="navbar-header pull-left"><a href="#" class="navbar-brand">
                <small><i class="icon-leaf"></i> 管理后台</small>
            </a></div>
        <div class="navbar-header pull-right" role="navigation">
            <ul class="nav ace-nav">
                <li class="light-blue dropdown-modal"><a data-toggle="dropdown" href="#" class="dropdown-toggle"><span class="user-info"><small><?php echo '('.$user['groupName'].')'?></small><?php echo $user['username']; ?></span><i
                            class="icon-caret-down"></i></a>
                    <ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                        <li class="divider"></li>
                        <li><a href="#" id="menu-reset-pwd"><i class="layui-icon">&#xe631;</i> 修改密码 </a></li>
                        <li><a href="<?php echo site_url('login/logout'); ?>"><i class="icon-off"></i> 退出</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>

<!--修改密码页面-->
<div id="layer-reset-pwd" style="display:none;">
    <form class="layui-form" id="form-reset-pwd" action="#" onsubmit="return false;">
        <input type="text" name="id" value=<?php echo $user['id']; ?> style="display:none">
        <div class="layui-form-item">
            <label class="layui-form-label">原始密码</label>
            <div class="layui-input-inline">
                <input class="layui-input" type="password" name="password" id="password" placeholder="请填写原始密码" autocomplete="off" maxlength="20" lay-verify="passwd" >
            </div>
        </div>
        <div class="layui-form-item" id="pwd">
            <label class="layui-form-label">新密码</label>
            <div class="layui-input-inline">
                <input class="layui-input" type="password" name="newpassword" id="newpassword" placeholder="请填写6到20位新密码" autocomplete="off" maxlength="20" lay-verify="passwd">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">确认新密码</label>
            <div class="layui-input-inline">
                <input class="layui-input" type="password" name="passconf" id="passconf" placeholder="请确认填写新密码" autocomplete="off" maxlength="20" lay-verify="passwd" >
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"></label>
            <div class="layui-input-inline" style="width: 150px;">
                <button class="layui-btn" lay-submit lay-filter="pwdreset">确认</button>
                <button class="layui-btn layui-btn-primary" type="reset">重置</button>
            </div>
        </div>
    </form>
</div>

<script src="<?php echo $this->config->item('statics_path'); ?>/other/js/public/top.js"></script>




