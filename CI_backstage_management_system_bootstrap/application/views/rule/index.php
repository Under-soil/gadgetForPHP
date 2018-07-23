<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- 模态框（Modal） -->
<div class="modal fade" id="myModal" tabindex="99" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
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
<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">添加权限</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="box box-info">
                    <!-- form start -->
                    <form class="form-horizontal" data-toggle="validator" id="addForm" role="form" onsubmit="return false">
                        <input name="pid" type="hidden" />
                        <div class="box-body">
                            <div class="form-group">
                                <label for="realname" class="col-sm-3 control-label">权限名</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control"  name="title" placeholder="权限名" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="realname" class="col-sm-3 control-label">权限</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control"  name="name" placeholder="链接" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="realname" class="col-sm-3 control-label">图标</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control"  name="ico" placeholder="图标"  maxlength="20"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="realname" class="col-sm-3 control-label">排序</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control"  name="order_number" placeholder="正整数"  maxlength="3"/>
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
                <h5 class="modal-title" id="exampleModalLongTitle">编辑权限</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="box box-info">
                    <!-- form start -->
                    <input name="flag" type="hidden" >
                    <input name="index" type="hidden" >
                    <form class="form-horizontal" data-toggle="validator" id="editForm" role="form" onsubmit="return false">
                        <input name="id" type="hidden" >
                        <div class="box-body">
                            <div class="form-group">
                                <label for="realname" class="col-sm-3 control-label">权限</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control"  name="title" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="realname" class="col-sm-3 control-label">权限名</label>
                                <div class="radio col-sm-9">
                                    <input type="text" class="form-control"  name="name" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="realname" class="col-sm-3 control-label">图标</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control"  name="ico" placeholder="图标"  maxlength="20"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="realname" class="col-sm-3 control-label">排序</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control"  name="order_number" placeholder="正整数"  maxlength="3"/>
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
        var cur_table = null;
        $(function () {
            //1.初始化Table
            var oTable = new TableInit();
            oTable.Init();
            //2.初始化Button的点击事件
            var oButtonInit = new ButtonInit();
            oButtonInit.Init();
        });

        var TableInit = function () {
            var oTableInit = new Object();
            //初始化Table
            oTableInit.Init = function () {
                $("#data").bootstrapTable({
                    url: 'index.php?/admin/rule/data/',
                    method: 'post',
                    striped:true,
                    toolbar: '#toolbar',                //工具按钮用哪个容器
                    toolbarAlign: 'left',
                    detailView: true,//父子表
                    pagination:true,
                    sidePagination: "server",
                    uniqueId:'id',
                    pageNumber:1,
                    pageSize: 100,
                    pageList: [],        //可供选择的每页的行数（*）
                    dataField: "data",//服务端返回数据键值 就是说记录放的键值是data，分页时使用总记录数的键值为total
                    search:false,
                    showFooter:false,
                    columns: [
                        {
                            field:'id',
                            title:'节点',
                        },
                        {
                            align: 'center',
                            title: '父节点',
                            formatter:function(value,record,index) {
                                return '<input class="input-medium"  style="width:40px;height:25px;" type="text" name="'+record.id+'" value="'+record.pid+'" data-level="0"  />';
                            }
                        },
                        {
                            field: 'title',
                            align: 'left',
                            title: '权限名'
                        },
                        {
                            field: 'name',
                            align: 'left',
                            title: '权限'
                        },
                        {
                            align: 'left',
                            title: '操作',
                            formatter:function(value,record,index) {
                                return '<a href="javascript:;"  onclick="edit('+record.id+','+index+', 0)">修改</a> | <a href="javascript:del('+record.id+', 0)">删除</a> | <a href="javascript:;"  onclick="add_child('+record.id+')">添加子权限</a>';
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
                            modalOpen(sourceData.m);
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
            //初始化子表格(无线循环)
            oTableInit.InitSubTable = function (index, row, $detail) {
                var parentid = row.id,
                    pLevel = $('input[name='+parentid+']').data('level'),
                    level = pLevel + 1,
                    flag = false;
                if (level < 2)
                {
                    flag = true;
                }
                cur_table = $detail.html('<table></table>').find('table');
                $(cur_table).bootstrapTable({
                    url: 'index.php?/admin/rule/child/',
                    contentType:'application/x-www-form-urlencoded',
                    method:'post',
                    clickToSelect: true,
                    detailView: flag,//父子表
                    pageSize: 99999,
                    queryParams:{id:row.id},
                    data:'data',
                    uniqueId: "id",                     //每一行的唯一标识，一般为主键列
                    columns: [
                        {
                            field:'id',
                            title:'节点',
                        },
                        {
                            align: 'center',
                            title: '父节点',
                            formatter:function(value,record,index) {
                                return '<input class="input-medium" style="width:40px;height:25px;" type="text" name="'+record.id+'" value="'+record.pid+'" data-level="'+level+'" />';
                            }
                        },
                        {
                            field: 'title',
                            align: 'left',
                            title: '权限名'
                        },
                        {
                            field: 'name',
                            align: 'left',
                            title: '权限'
                        },
                        {
                            align: 'left',
                            title: '操作',
                            formatter:function(value,record,index) {
                                if (level < 2)
                                {
                                    return '<a href="javascript:;" onclick="edit('+record.id+','+index+', 1)">修改</a> | <a href="javascript:del('+record.id+', 1)">删除</a> | <a href="javascript:;"  onclick="add_child('+record.id+')">添加子权限</a>';
                                } else
                                {
                                    return '<a href="javascript:;" onclick="edit('+record.id+','+index+', 1)">修改</a> | <a href="javascript:del('+record.id+', 1)">删除</a>';
                                }
                            }
                        }
                    ],
                    onExpandRow: function (index, row, $detail) {
                        oTableInit.InitSubTable(index, row, $detail);
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
            var postdata = $('form').serialize();

            oInit.Init = function () {
            };
            return oInit;
        };

        function modalOpen(msg) {
            $('#myModalLabel').html('系统提示');
            $('#myModal .modal-body').html(msg);
            $('#myModal').modal();
        }

        $('#add').click(function () {
            $("input[name='name'],input[name='title'],input[name='order_number'],input[name='ico']").val('');
            $("input[name='pid']").val(0);
            $('#addModal').modal();
        });

        function edit(id, index, flag) {
            var doc = '#data';
            if (flag > 0)
            {
                doc = cur_table
            }
            var row = $(doc).bootstrapTable('getRowByUniqueId', id);
            $('#editForm input[name=name]').val(row.name);
            $('#editForm input[name=pid]').val(row.pid);
            $('#editForm input[name=title]').val(row.title);
            $('#editForm input[name=id]').val(id);
            $('#editForm input[name=ico]').val(row.ico);
            $('#editForm input[name=order_number]').val(row.order_number);
            $('input[name=index]').val(index);
            $('input[name=flag]').val(flag);
            $('#editModal').modal();
        }

        function add_child(id) {
            $("input[name='name'],input[name='title'],input[name='ico'],input[name='order_number']").val('');
            $("input[name='pid']").val(id);
            $('#addModal').modal();
        }

        function del(id, flag) {
            Ewin.confirm({ message: "确认要删除选择的数据吗？" }).on(function (e) {
                if (!e) {
                    return;
                }
                $('.btn-trash').attr('disabled', true);
                $.post('<?=site_url()?>/admin/rule/delete', {'id': id}, function(data){
                    if (data.r == 2)
                    {
                        modalOpen('删除成功');
                        if (flag > 0)
                        {
                            $(cur_table).bootstrapTable('removeByUniqueId', id);
                        } else {
                            $('#data').bootstrapTable('removeByUniqueId', id);
                        }
                    }
                    else if (data.r == 1000)
                    {
                        window.top.location.reload();
                    }
                    else
                    {
                        modalOpen(data.m);
                    }
                }, "json");
            });
        }

        $('#addForm').bootstrapValidator({
            feedbackIcons: {        //提示图标
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            trigger: 'blur',
            fields:{
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
                $.post('index.php?/admin/rule/add', $('#addForm').serialize(), function(data){
                    if (data.r == 2)
                    {
                        $('#addModal').modal('hide');
                        modalOpen('添加成功');
                        $('#addSubmit').attr('disabled', false);
                        if ($('#addForm input[name=pid]').val() == 0)
                        {
                            $('#data').bootstrapTable('insertRow', {index:data.m.id, row:data.m});
                        }
                        else
                        {
                            $(cur_table).bootstrapTable('insertRow', {index:data.m.id, row:data.m});
                        }
                    }
                    else if (data.r == 1000)
                    {

                        window.top.location.reload();
                    }
                    else
                    {
                        $('#addSubmit').attr('disabled', false);
                        modalOpen(data.m);
                    }
                }, "json");
            }
        });

        $('#editSubmit').click(function () {
            $('#editForm').bootstrapValidator('validate');
            if ($('#editForm').data("bootstrapValidator").isValid())
            {
                $('#editSubmit').attr('disabled', true);
                //提交逻辑
                $.post('index.php?/admin/rule/edit', $('#editForm').serialize(), function(data){
                    if (data.r == 2)
                    {
                        $('#editModal').modal('hide');
                        modalOpen('修改成功');
                        $('#editSubmit').attr('disabled', false);
                        var flag = $('input[name=flag]').val(),
                            index = $('input[name=index]').val(),
                            doc = '#data',
                            row = {
                                'name':$('#editForm input[name=name]').val(),
                                'title':$('#editForm input[name=title]').val(),
                                'ico':$('#editForm input[name=ico]').val(),
                                'id':$('#editForm input[name=id]').val()
                            };
                        if (flag > 0)
                        {
                            doc = cur_table
                        }
                        $(doc).bootstrapTable(('updateRow'), {index:index, row:row});
                    }
                    else if (data.r == 1000)
                    {

                        window.top.location.reload();
                    }
                    else
                    {
                        $('#editSubmit').attr('disabled', false);
                        modalOpen(data.m);
                    }
                }, "json");
            }
        });

    </script>