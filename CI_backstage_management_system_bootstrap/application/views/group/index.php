<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Modal -->
<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">添加用户</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="box box-info">
                    <!-- form start -->
                    <form class="form-horizontal" data-toggle="validator" id="userForm" role="form" onsubmit="return false">
                        <input type="hidden" name="level" />
                        <div class="box-body">
                            <div class="form-group">
                                <label for="realname" class="col-sm-3 control-label">手机号</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control"  name="phone" id="phone" maxlength="11" placeholder="请输入手机号" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="realname" class="col-sm-3 control-label">再次确认</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control"  name="repeat_phone" id="repeat_phone" maxlength="11" placeholder="请再次输入手机号" />
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="button" class="btn btn-info pull-right" id="userSubmit">添加</button>
                        </div>
                        <!-- /.box-footer -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">添加用户组</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="box box-info">
                    <!-- form start -->
                    <form class="form-horizontal" data-toggle="validator" id="addForm" role="form" onsubmit="return false">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="realname" class="col-sm-3 control-label">用户组名</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control"  name="title" maxlength="10" placeholder="用户组名" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="realname" class="col-sm-3 control-label">角色分类</label>
                                <div class="col-sm-9">
                                    <label class="radio-inline">
                                        <input type="radio" name="type"  value="0" checked="checked"> 系统角色
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="type"  value="1"> 推广角色
                                    </label>
                                </div>
                            </div>
                            <div class="form-group agent">
                                <label for="realname" class="col-sm-3 control-label">会员返佣</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                    <input type="text" class="form-control"  name="commission" maxlength="3" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')"  min="1" max="100" placeholder="直属会员税收的返利比例" disabled required/>
                                    <div class="input-group-addon">%</div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group agent">
                                <label for="realname" class="col-sm-3 control-label">下级返佣</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                    <input type="text" class="form-control"  name="commissionx" maxlength="3" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')"  min="1" max="100" placeholder="下级推广员会员税收的返利比例" disabled required/>
                                    <div class="input-group-addon">%</div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group agent">
                                <label for="realname" class="col-sm-3 control-label">下下级返佣</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <input type="text" class="form-control"  name="commissionthree" maxlength="3" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')"  min="1" max="100" placeholder="下下级推广员会员税收的返利比例" disabled required/>
                                        <div class="input-group-addon">%</div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group agent">
                                <label for="realname" class="col-sm-3 control-label">升级条件</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control"  name="cumulative_coins" maxlength="6" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')"  min="0" max="999999" placeholder="设置升级需满足的累计收益金额" disabled required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">角色说明</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control"  name="desc" maxlength="20" placeholder="角色说明" required/>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="button" class="btn btn-info pull-right" id="addSubmit">添加</button>
                        </div>
                        <!-- /.box-footer -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">编辑分组信息</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="box box-info">
                    <!-- form start -->
                    <input type="hidden" name="index">
                    <form class="form-horizontal" data-toggle="validator" id="editForm" role="form" onsubmit="return false">
                        <input type="hidden" name="id" />
                        <div class="box-body">
                            <div class="form-group">
                                <label for="realname" class="col-sm-3 control-label">分组名</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="title" pattern="^[0-9\u4e00-\u9fa5]{2,10}$"/>
                                </div>
                            </div>
                            <div class="form-group agent">
                                <label for="realname" class="col-sm-3 control-label">会员返佣</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <input type="text" class="form-control"  name="commission" maxlength="3" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')"  min="1" max="100" placeholder="直属会员税收的返利比例"  required/>
                                        <div class="input-group-addon">%</div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group agent">
                                <label for="realname" class="col-sm-3 control-label">下级返佣</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <input type="text" class="form-control"  name="commissionx" maxlength="3" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')"  min="1" max="100" placeholder="下级推广员会员税收的返利比例"  required/>
                                        <div class="input-group-addon">%</div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group agent">
                                <label for="realname" class="col-sm-3 control-label">下下级返佣</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <input type="text" class="form-control"  name="commissionthree" maxlength="3" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')"  min="1" max="100" placeholder="下下级推广员会员税收的返利比例"  required/>
                                        <div class="input-group-addon">%</div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group agent">
                                <label for="realname" class="col-sm-3 control-label">升级条件</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control"  name="cumulative_coins" maxlength="6" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')"  min="0" max="999999" placeholder="设置升级需满足的累计收益金额" required/>
                                </div>
                            </div>

                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="button" class="btn btn-info pull-right" id="editSubmit">保存</button>
                        </div>
                        <!-- /.box-footer -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="panel-body" style="padding-bottom:0px;">
                <!-- /.box-header -->
                <div class="box-body">
                    <div id="example1_wrapper" class="dataTables_wrapper  dt-bootstrap">
                        <div class="row">
                            <div class="col-sm-12">
                                <div id="toolbar">
                                    <div class="btn-group">
                                        <button class="btn btn-default" id="add">
                                            <i class="glyphicon glyphicon-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <table id="data" class="table  table-striped" >
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>


    <script>
        $(function () {
            //1.初始化Table
            var oTable = new TableInit();
            oTable.Init();
            //2.初始化Button的点击事件
            var oButtonInit = new ButtonInit();
            oButtonInit.Init();
            $('.agent').hide();

            $(":radio").click(function(){
                if ($(this).val() == 1)
                {
                    $('.agent').show();
                    $('.agent input[type=text]').attr('disabled', false);
                } else {
                    $('.agent').hide();
                    $('.agent input[type=text]').attr('disabled', true);
                }
            });
        });

        function edit(id, index) {
            $('#editForm')[0].reset();
            if ($("#editForm").data('bootstrapValidator')) {
                 $("#editForm").data('bootstrapValidator').destroy();
                 $('#editForm').data('bootstrapValidator', null);
            }
            var row = $('#data').bootstrapTable(('getRowByUniqueId'), id);
            $("input[name='index']").val(index);
            $("#editForm input[name='id']").val(row.id);
            $('#editForm input[name="title"]').val(row.title);
            $('#editForm input[name="name"]').val(row.name);
            $('#editForm input[name="num_index"]').val(row.num_index);
            if (row.type == 1)
            {
                $('#editForm input[name="commission"]').val(parseInt(row.commission * 100));
                $('#editForm input[name="commissionx"]').val(parseInt(row.commissionx * 100));
                $('#editForm input[name="commissionthree"]').val(parseInt(row.commissionthree * 100));
                $('#editForm input[name="cumulative_coins"]').val(row.cumulative_coins);


                $('#editForm input[name="commission"]').attr('disabled', false);
                $('#editForm input[name="commissionx"]').attr('disabled', false);
                $('#editForm input[name="commissionthree"]').attr('disabled', false);
                $('#editForm input[name="cumulative_coins"]').attr('disabled', false);
                $('#editForm .agent').show();
            } else {
                $('#editForm input[name="commission"]').attr('disabled', true);
                $('#editForm input[name="commissionx"]').attr('disabled', true);
                $('#editForm input[name="commissionthree"]').attr('disabled', true);
                $('#editForm input[name="cumulative_coins"]').attr('disabled', true);
                $('#editForm .agent').hide();
            }
            $('#editModal').modal();
        }

        function addUser(id) {
            $('#userForm')[0].reset();//resetForm
            if ($("#userForm").data('bootstrapValidator')) {
                $("#userForm").data('bootstrapValidator').destroy();
                $('#userForm').data('bootstrapValidator', null);
            }
            $('input[name=level]').val(id);
            $('#userModal').modal();
        }

        var TableInit = function () {
            var oTableInit = new Object();
            //初始化Table
            oTableInit.Init = function () {
                $("#data").bootstrapTable({
                    url: 'index.php?/admin/group/data',
                    method: 'post',
                    striped:true,
                    toolbar: '#toolbar',                //工具按钮用哪个容器
                    toolbarAlign: 'left',
                    contentType:'application/x-www-form-urlencoded',
                    detailView: false,//父子表
                    pagination:true,
                    queryParams: oTableInit.queryParams,//传递参数（*）
                    sidePagination: "server",
                    pageNumber:1,
                    uniqueId:'id',
                    pageSize: 20,
                    pageList: [],        //可供选择的每页的行数（*）
                    dataField: "data",//服务端返回数据键值 就是说记录放的键值是data，分页时使用总记录数的键值为total
                    search:false,
                    showFooter:false,
                    columns: [
                        {
                            field: 'id',
                            align: 'center',
                            title: '级别'
                        },
                        {
                            field: 'title',
                            align: 'center',
                            title: '用户组名'
                        },
                        {
                            field: 'type',
                            align: 'center',
                            title: '用户组类型',
                            formatter:function(value,record,index) {
                                if (value == 1)
                                {
                                    return '推广角色';
                                }
                                else
                                {
                                    return '系统角色';
                                }
                            }
                        },
                        {
                            field: 'desc',
                            align: 'center',
                            title: '描述'
                        },
                        {
                            align: 'left',
                            title: '操作',
                            formatter:function(value,record,index) {
                                var html = '';
                                if (record.type == 1)
                                {
                                    html = '<a href="javascript:;"  onclick="edit('+record.id+', '+index+')">修改</a> |  <a href="javascript:rule('+record.id+');">分配权限</a>';
                                }
                                else
                                {
                                    html = '<a href="javascript:;"  onclick="edit('+record.id+', '+index+')">修改</a> |  <a href="javascript:rule('+record.id+');">分配权限</a> | <a href="javascript:addUser('+record.id+');">添加成员</a>';
                                }
                                return html;
                            }
                        }
                    ],
                    //注册加载子表的事件。注意下这里的三个参数！
                    onExpandRow: function (index, row, $detail) {
                        oTableInit.InitSubTable(index, row, $detail);
                    },
                    responseHandler:function (sourceData) {
                        if (sourceData.r == 1000)
                        {
                            window.top.location.reload();
                        } else if(sourceData.r == 2000)
                        {
                            Ewin.alert(sourceData.m);
                            return {
                                'total':0,
                                'data':[],
                                'curPage':1
                            }
                        } else {
                            return {
                                'total':sourceData.totalRows,
                                'data': sourceData.data,
                                'curPage': sourceData.curPage
                            };
                        }
                    }
                });
            };
            //得到查询的参数
            oTableInit.queryParams = function (params) {
                return {
                    pageSize: params.limit,   //页面大小
                    curPage:  Math.ceil(params.offset / params.limit) + 1,  //页码
                };
            };
            return oTableInit;
        };
        var ButtonInit = function () {
            var oInit = new Object();
            oInit.Init = function () {
            };
            return oInit;
        };


        $('#add').click(function () {
            $('.agent').hide();
            $('#addForm')[0].reset();//resetForm
            if ($("#addForm").data('bootstrapValidator')) {
                $("#addForm").data('bootstrapValidator').destroy();
                $('#addForm').data('bootstrapValidator', null);
            }
            $('#addModal').modal();
        });

        $('#addForm').bootstrapValidator({
            trigger: 'blur',
            fields:{
                title:{
                    validators:{
                        regexp:{
                            regexp:/^[0-9\u4e00-\u9fa5]{2,10}$/,
                            message:'分组名仅支持2-10个汉字及数字'
                        }
                    }
                },
            }
        }).on('success.form.bv', function(e) {
            e.preventDefault();
        });

        $('#addSubmit').click(function () {
            $('#addForm').bootstrapValidator('validate');
            if ($('#addForm').data("bootstrapValidator").isValid())
            {
                $('#addSubmit').attr('disabled', true);
                //提交逻辑
                $.post('index.php?/admin/group/add', $('#addForm').serialize(), function(data){
                    if (data.r == 2)
                    {
                        var row = {
                            'title' : $('#addForm input[name=title]').val(),
                            'desc' : $('#addForm input[name=desc]').val(),
                            'id': data.id,
                            'type':$('#addForm input[name=type]:checked').val(),
                        };
                        $('#addModal').modal('hide');
                        Ewin.alert('添加成功');
                        $('#addSubmit').attr('disabled', false);
                        $('#data').bootstrapTable('insertRow', {index:999, row:row});
                    }
                    else if (data.r == 1000)
                    {
                        window.top.location.reload();
                    }
                    else
                    {
                        $('#addSubmit').attr('disabled', false);
                        Ewin.alert(data.m);
                    }
                }, "json");
            }
        });

        function setstate(opt, id, index){
            var param = {"id":id, "opt":opt};
            $.post('<?=site_url()?>/dev/game/setstate', param, function(data){
                if (data.r == 2)
                {
                    Ewin.alert('设置成功');
                    $('#data').bootstrapTable('updateCell', {index: index, field: state, value:opt});
                }
                else if (data.r == 1000)
                {
                    top.document.location.reload();
                }
                else
                {
                    Ewin.alert(data.m);
                }
            }, "json");
        }

        $('#editForm').bootstrapValidator({
            trigger: 'blur',
            fields:{
                title:{
                    validators:{
                        regexp:{
                            regexp:/^[0-9\u4e00-\u9fa5]{2,10}$/,
                            message:'分组名仅支持2-10个汉字及数字'
                        }
                    }
                },
            }
        }).on('success.form.bv', function(e) {
            e.preventDefault();
        });

        $('#editSubmit').click(function () {
            $('#editForm').bootstrapValidator('validate');
            if ($('#editForm').data("bootstrapValidator").isValid())
            {
                $('#editSubmit').attr('disabled', true);
                //提交逻辑
                $.post('index.php?/admin/group/edit', $('#editForm').serialize(), function(data){
                    if (data.r == 2)
                    {
                        var index = $('input[name=index]').val();
                        var row = {
                            'id':$('#editForm input[name=id]').val(),
                            'title':$('#editForm input[name=title]').val(),
                            'commission':$('#editForm input[name=commission]').val() / 100,
                            'commissionx':$('#editForm input[name=commissionx]').val() / 100,
                            'commissionthree':$('#editForm input[name=commissionthree]').val() / 100,
                            'cumulative_coins':$('#editForm input[name=cumulative_coins]').val(),
                        };
                        $('#editModal').modal('hide');
                        Ewin.alert('修改成功');
                        $('#editSubmit').attr('disabled', false);
                        $('#data').bootstrapTable('updateRow', {index: index, row: row});
                    }
                    else if (data.r == 1000)
                    {

                        window.top.location.reload();
                    }
                    else
                    {
                        $('#editSubmit').attr('disabled', false);
                        Ewin.alert(data.m);
                    }
                }, "json");
            }
        });

        function userFormValidator() {
            $("#userForm").bootstrapValidator({
                live: 'enabled',
                excluded: [':disabled', ':hidden', ':not(:visible)'],
                feedbackIcons: {//根据验证结果显示的各种图标
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    phone: {
                        validators: {
                            notEmpty: {
                                message: '请输入'
                            },
                            regexp: {//正则验证
                                regexp: /^1[34578]\d{9}$/,
                                message: '手机号格式错误'
                            },
                        }
                    },
                    repeat_phone:{
                        validators:{
                            notEmpty: {
                                message: '请输入'
                            },
                            identical:{
                                field:'phone',
                                message:'手机号输入不一致'
                            }
                        }
                    },
                }
            })
        }

        $('#userSubmit').click(function () {
            userFormValidator();
            $('#userForm').bootstrapValidator('validate');
            if ($('#userForm').data("bootstrapValidator").isValid())
            {
                $('#userSubmit').attr('disabled', true);
                //提交逻辑
                $.post('index.php?/admin/user/add', $('#userForm').serialize(), function(data){
                    if (data.r == 2)
                    {
                        $('#userModal').modal('hide');
                        Ewin.alert('添加成功');
                        $('#userSubmit').attr('disabled', false);
                    }
                    else if (data.r == 1000)
                    {

                        window.top.location.reload();
                    }
                    else
                    {
                        $('#userSubmit').attr('disabled', false);
                        Ewin.alert(data.m);
                    }
                }, "json");
            }
        });

        function rule(id) {
            var url = '<?=site_url()?>/admin/group/rule/'+id;
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

    </script>