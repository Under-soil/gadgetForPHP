<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php $this->_block('title'); ?><?php $this->_endblock(); ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?php echo $this->config->item('statics_path'); ?>/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo $this->config->item('statics_path'); ?>/font-awesome-4.7.0/css/font-awesome.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo $this->config->item('statics_path'); ?>/adminlte/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo $this->config->item('statics_path'); ?>/adminlte/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="<?php echo $this->config->item('statics_path'); ?>/bootstrapvalidator/css/bootstrapValidator.min.css">
    <link rel="stylesheet" href="<?php echo $this->config->item('statics_path'); ?>/adminlte/css/custom-forms.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="<?php echo $this->config->item('statics_path'); ?>/bootstrap-table/bootstrap-table.min.css">
    <?php $this->_block('head'); ?><!--这里是载入私有的CSS和JS--><?php $this->_endblock(); ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="#" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b><?= $this->config->item('app_name'); ?></b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b><?= $this->config->item('app_name'); ?></b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="hidden-xs"><?= $user['username']; ?>-<?= '('.$user['groupName'].')'?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="#"  id="menu-reset-pwd" class="btn btn-default btn-flat">修改密码</a>
                                </div>
                                <div class="pull-right">
                                    <a href="<?php echo site_url('login/logout'); ?>" class="btn btn-default btn-flat">退出</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- =============================================== -->

    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu" data-widget="tree">
                <?php
                if ($nav && is_array($nav)) {
                    foreach ($nav as $v) {
                        if (empty($v['_child'])) { ?>
                            <li class="treeview">
                                <a href="<?php echo site_url($v['name']); ?>">
                                    <i class="fa fa-<?php echo isset($v['ico']) ? $v['ico'] : ''; ?> icon-test"></i>
                                    <span class="menu-text"><?php echo $v['title']; ?></span>
                                </a>
                            </li>
                            <?php
                        } else { ?>
                            <li class="treeview">
                                <a href="#" data-title="<?php echo $v['title']; ?>">
                                    <i class="fa fa-<?php echo isset($v['ico']) ? $v['ico'] : '';  ?>"></i>
                                    <span><?php echo $v['title']; ?></span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <?php
                                    foreach ($v['_child'] as $n) { ?>
                                        <li><a data-title="<?php echo $n['title']; ?>" href="javascript:void(0)" data-url="<?php echo site_url($n['name']); ?>"><i class="fa fa-circle-o"></i><?php echo $n['title']; ?></a></li>
                                    <?php }
                                    ?>
                                </ul>
                            </li>
                        <?php }
                    }
                }
                ?>
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- =============================================== -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h4>
                <ol class="breadcrumb">
                    <li><i class="fa fa-dashboard"></i> 首页</li>
                    <li class="active"></li>
                </ol>
            </h4>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
    </footer>

    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div>

<!-- Modal -->
<div class="modal fade" id="pwdModal" tabindex="-1">
    <div class="modal-dialog">
        <!-- form start -->
        <form class="form-horizontal" data-toggle="validator" id="pwdForm" role="form" onsubmit="return false">
            <input type="hidden" name="id" value=<?php echo $user['id']; ?> />
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">修改密码</h4>
            </div>
            <div class="modal-body">
                <div class="box box-info">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="password" class="col-sm-3 control-label">原始密码</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control"  name="password" maxlength="20" pattern="(?!\s+)(?!^\[0-9]+$)(?!^\[a-zA-Z]+$)(?!^\[_#@]+$).{6,20}" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="newpassword" class="col-sm-3 control-label">新密码</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control"  name="newpassword" maxlength="20" pattern="(?!\s+)(?!^\[0-9]+$)(?!^[a-zA-Z]+$)(?!^[_#@]+$).{6,20}" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="newpassword" class="col-sm-3 control-label">确认新密码</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control"  name="passconf"  maxlength="20" pattern="(?!\s+)(?!^\[0-9]+$)(?!^[a-zA-Z]+$)(?!^[_#@]+$).{6,20}" />
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-default pull-left" >重置</button>
                <button type="button" class="btn btn-primary" id="pwdreset">确认</button>
            </div>
        </div>
        <!-- /.modal-content -->
        </form>
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!-- 模态框（Modal） -->
<div class="modal fade" id="tipModal" tabindex="99" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="tipModalLabel">提示
                </h4>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<!-- jQuery 3 -->
<script src="<?php echo $this->config->item('statics_path'); ?>/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo $this->config->item('statics_path'); ?>/bootstrap/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="<?php echo $this->config->item('statics_path'); ?>/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo $this->config->item('statics_path'); ?>/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo $this->config->item('statics_path'); ?>/adminlte/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo $this->config->item('statics_path'); ?>/adminlte/js/demo.js"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="<?php echo $this->config->item('statics_path'); ?>/bootstrap-table/bootstrap-table.min.js"></script>
<!-- Latest compiled and minified Locales -->
<script src="<?php echo $this->config->item('statics_path'); ?>/bootstrap-table/locale/bootstrap-table-zh-CN.min.js"></script>
<script src="<?php echo $this->config->item('statics_path'); ?>/bootstrapvalidator/js/bootstrapValidator.min.js"></script>
<script src="<?php echo $this->config->item('statics_path'); ?>/bootstrapvalidator/js/language/zh_CN.js"></script>
<script src="<?php echo $this->config->item('statics_path'); ?>/bootstrap-daterangepicker/moment.min.js"></script>
<script src="<?php echo $this->config->item('statics_path'); ?>/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="<?php echo $this->config->item('statics_path'); ?>/clipboard/clipboard.min.js"></script>
<script>
    $(document).ready(function () {
        $('.sidebar-menu').tree();

        //用户新增 显示
        $("#menu-reset-pwd").on('click', function() {
            $('#pwdForm')[0].reset();
            if ($("#pwdForm").data('bootstrapValidator'))
            {
                $("#pwdForm").data('bootstrapValidator').destroy();
                $('#pwdForm').data('bootstrapValidator', null);
            }
            //$('#tips span').css('background-color', 'white');
            $('#pwdModal').modal();
        });

        $('#pwdForm').bootstrapValidator({
            trigger: 'blur',
            fields:{
                passconf:{
                    validators:{
                        identical: {
                            field:'newpassword',
                            message: '两次输入密码不一致'
                        }
                    }
                }
            }
        }).on('success.form.bv', function(e) {
            e.preventDefault();
        });

        $('#pwdreset').click(function () {
            $('#pwdForm').bootstrapValidator('validate');
            if ($('#pwdForm').data("bootstrapValidator").isValid())
            {
                $('#pwdreset').attr('disabled', true);
                $.post('index.php?/login/pwdUpdate/', $('#pwdForm').serialize(), function(data){
                    if (data.r == 0)
                    {
                        $('#pwdModal').modal('hide');
                        $('#tipModal .modal-body').html('修改成功');
                        $('#tipModal').modal();
                        window.location.href = 'index.php?/Login/logout/';
                    }
                    else if (data.r == 1000)
                    {
                        top.document.location.reload();
                    }
                    else
                    {
                        $('#tipModal .modal-body').html(data.m);
                        $('#tipModal').modal();
                        $('#pwdreset').attr('disabled', false);
                    }
                }, "json");
            }
        });


        window.Ewin = function () {
                var html = '<div id="[Id]" class="modal fade" role="dialog" aria-labelledby="modalLabel">' +
                    '<div class="modal-dialog modal-sm">' +
                    '<div class="modal-content">' +
                    '<div class="modal-header">' +
                    '<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>' +
                    '<h4 class="modal-title" id="modalLabel">[Title]</h4>' +
                    '</div>' +
                    '<div class="modal-body">' +
                    '<p>[Message]</p>' +
                    '</div>' +
                    '<div class="modal-footer">' +
                    '<button type="button" class="btn btn-default cancel" data-dismiss="modal">[BtnCancel]</button>' +
                    '<button type="button" class="btn btn-primary ok" data-dismiss="modal">[BtnOk]</button>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>';


                var dialogdHtml = '<div id="[Id]" class="modal fade" role="dialog" aria-labelledby="modalLabel">' +
                    '<div class="modal-dialog">' +
                    '<div class="modal-content">' +
                    '<div class="modal-header">' +
                    '<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>' +
                    '<h4 class="modal-title" id="modalLabel">[Title]</h4>' +
                    '</div>' +
                    '<div class="modal-body">' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>';
                var reg = new RegExp("\\[([^\\[\\]]*?)\\]", 'igm');
                var generateId = function () {
                    var date = new Date();
                    return 'mdl' + date.valueOf();
                }
                var init = function (options) {
                    options = $.extend({}, {
                        title: "操作提示",
                        message: "提示内容",
                        btnok: "确定",
                        btncl: "取消",
                        width: 200,
                        auto: false
                    }, options || {});
                    var modalId = generateId();
                    var content = html.replace(reg, function (node, key) {
                        return {
                            Id: modalId,
                            Title: options.title,
                            Message: options.message,
                            BtnOk: options.btnok,
                            BtnCancel: options.btncl
                        }[key];
                    });
                    $('body').append(content);
                    $('#' + modalId).modal({
                        width: options.width,
                        backdrop: 'static'
                    });
                    $('#' + modalId).on('hide.bs.modal', function (e) {
                        $('body').find('#' + modalId).remove();
                    });
                    return modalId;
                }

                return {
                    alert: function (options) {
                        if (typeof options == 'string') {
                            options = {
                                message: options
                            };
                        }
                        var id = init(options);
                        var modal = $('#' + id);
                        modal.find('.ok').removeClass('btn-success').addClass('btn-primary');
                        modal.find('.cancel').hide();

                        return {
                            id: id,
                            on: function (callback) {
                                if (callback && callback instanceof Function) {
                                    modal.find('.ok').click(function () { callback(true); });
                                }
                            },
                            hide: function (callback) {
                                if (callback && callback instanceof Function) {
                                    modal.on('hide.bs.modal', function (e) {
                                        callback(e);
                                    });
                                }
                            }
                        };
                    },
                    confirm: function (options) {
                        var id = init(options);
                        var modal = $('#' + id);
                        modal.find('.ok').removeClass('btn-primary').addClass('btn-success');
                        modal.find('.cancel').show();
                        return {
                            id: id,
                            on: function (callback) {
                                if (callback && callback instanceof Function) {
                                    modal.find('.ok').click(function () { callback(true); });
                                    modal.find('.cancel').click(function () { callback(false); });
                                }
                            },
                            hide: function (callback) {
                                if (callback && callback instanceof Function) {
                                    modal.on('hide.bs.modal', function (e) {
                                        callback(e);
                                    });
                                }
                            }
                        };
                    },
                    dialog: function (options) {
                        options = $.extend({}, {
                            title: 'title',
                            url: '',
                            width: 800,
                            height: 550,
                            onReady: function () { },
                            onShown: function (e) { }
                        }, options || {});
                        var modalId = generateId();

                        var content = dialogdHtml.replace(reg, function (node, key) {
                            return {
                                Id: modalId,
                                Title: options.title
                            }[key];
                        });
                        $('body').append(content);
                        var target = $('#' + modalId);
                        target.find('.modal-body').load(options.url);
                        if (options.onReady())
                            options.onReady.call(target);
                        target.modal();
                        target.on('shown.bs.modal', function (e) {
                            if (options.onReady(e))
                                options.onReady.call(target, e);
                        });
                        target.on('hide.bs.modal', function (e) {
                            $('body').find(target).remove();
                        });
                    }
                }
            }();
    });
    $('.treeview-menu > li > a').click(function () {
        if ($(this).hasClass('click_able'))
        {
            return false;
        }
        $('.treeview-menu > li > a').css('color', '#8aa4af');
        $(this).css('color', 'white');
        var url = $(this).data('url');
        $('.treeview-menu > li > a').removeClass('click_able');
        $(this).addClass('click_able');
        //$('.content-header h4').html($(this).data('title'));
        $('.breadcrumb').children().eq(0).html($(this).parent().parent().parent().children().first().data('title'));
        $('.breadcrumb').children().last().html($(this).data('title'));
        if ($('.daterangepicker').length) {
            $('.daterangepicker').remove();
        }
        refresh(url);
        return false;
    });

    function refresh(url) {
        $.ajax({
            url: url,
            async:false,
            type:'post',
            dataType:'html',
            success:function(data) {
                if(!data.match("^\{(.+:.+,*){1,}\}$"))
                {
                    $('.content').html(data);
                } else {
                    var obj = eval('(' + data + ')');
                    if (obj.r == 1000)
                    {
                        window.top.location.reload();
                    } else
                    {
                        Ewin.alert(obj.m);
                    }
                }
            }
        });
    }

    var clipboard = new ClipboardJS('.btn-copy');
    clipboard.on('success', function(e) {
        e.clearSelection();
        Ewin.alert('复制成功');
    });
    clipboard.on('error', function(e) {
        Ewin.alert('复制失败');
    });

    /**
     * 时间格式化扩展
     * @param fmt
     * @returns {*}
     * @constructor
     *
     * 调用：
     * var time1 = new Date().Format("yyyy-MM-dd");
     * var time2 = new Date().Format("yyyy-MM-dd HH:mm:ss");
     *
     * var nowTime=new Date();
     * nowTime.setMonth(nowTime.getMonth()-1);
     * alert(nowTime.Format("yyyy-MM-dd HH:mm:ss");)//上月当前时间
     */
    Date.prototype.Format = function (fmt) { //author: meizz
        var o = {
            "M+": this.getMonth() + 1, //月份
            "d+": this.getDate(), //日
            "H+": this.getHours(), //小时
            "m+": this.getMinutes(), //分
            "s+": this.getSeconds(), //秒
            "q+": Math.floor((this.getMonth() + 3) / 3), //季度
            "S": this.getMilliseconds() //毫秒
        };
        if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
        for (var k in o)
            if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
        return fmt;
    };
</script>
</body>
</html>
