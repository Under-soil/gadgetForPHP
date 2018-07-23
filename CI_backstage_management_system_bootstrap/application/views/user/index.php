<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->_block('head');
?>
<link rel="stylesheet" href="<?php echo $this->config->item('statics_path'); ?>/adminlte/css/custom-forms.css">
<?php $this->_endblock();
foreach ($gInfo as $val)
{ ?>
    <input id="h_group_<?php echo $val['id']; ?>" value="<?php echo $val['title']; ?>" type="hidden" />
    <?php
}
?>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="panel-body" style="padding-bottom:0px;">
                <!-- /.box-header -->
                <div class="box-body">
                    <div id="example1_wrapper" class="dataTables_wrapper  dt-bootstrap">
                        <div class="row">
                            <div class="col-sm-12">
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
        });

        var TableInit = function () {
            var oTableInit = new Object();
            //初始化Table
            oTableInit.Init = function () {
                $('#data').bootstrapTable({
                    url:  'index.php?/admin/user/data',         //请求后台的URL（*）
                    dataType: "json",//期待返回数据类型
                    dataField: "data",//服务端返回数据键值 就是说记录放的键值是data，分页时使用总记录数的键值为total
                    method: 'post',                      //请求方式（*）
                    contentType:'application/x-www-form-urlencoded',
                    toolbar: '',                //工具按钮用哪个容器
                    striped: true,                      //是否显示行间隔色
                    cache: false,                       //是否使用缓存，默认为true，所以一般情况下需要设置一下这个属性（*）
                    pagination: true,                   //是否显示分页（*）
                    sortable: false,                     //是否启用排序
                    sortOrder: "asc",                   //排序方式
                    queryParamsType:'limit',
                    queryParams: oTableInit.queryParams,//传递参数（*）
                    sidePagination: "server",           //分页方式：client客户端分页，server服务端分页（*）
                    pageNumber:1,                       //初始化加载第一页，默认第一页
                    pageSize: 20,                       //每页的记录行数（*）
                    pageList: [10, 25, 50, 100],        //可供选择的每页的行数（*）
                    search: false,                       //是否显示表格搜索，此搜索是客户端搜索，不会进服务端，所以，个人感觉意义不大
                    strictSearch: false,
                    showColumns: true,                  //是否显示所有的列
                    showRefresh: true,                  //是否显示刷新按钮
                    minimumCountColumns: 2,             //最少允许的列数
                    clickToSelect: true,                //是否启用点击选中行
                    uniqueId: "id",                     //每一行的唯一标识，一般为主键列
                    showToggle:true,                    //是否显示详细视图和列表视图的切换按钮
                    cardView: false,                    //是否显示详细视图
                    detailView: false,                   //是否显示父子表
                    columns: [
                        {
                            field: "id",
                            title: "UID",
                            align: 'center'
                        },
                        {
                            field: "username",
                            title: "用户名",
                            align: 'center'
                        },
                        {
                            title: "角色",
                            align: 'center',
                            formatter:function(value,record,index){
                                return $('#h_group_'+record.level).val();
                            }
                        },
                        {
                            title: "用户状态",
                            align: 'center',
                            formatter:function(value,row,index){
                                if (row.state == 1)
                                {
                                    return '启用';
                                }
                                return '禁用';
                            }
                        },
                        {
                            title: "操作",
                            align: 'center',
                            formatter:function(value,record,index){
                                var html = '';
                                if (record.state == 1) {
                                    html =  '<a href="javascript:update('+record.id+','+record.level+', 0, '+index+')">禁用</a>';
                                } else {
                                    html = '<a href="javascript:update('+record.id+','+record.level+', 1, '+index+')">启用</a>';
                                }
                                return html;
                            }
                        }
                    ],
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
                            $('.pagination').show();
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

        function modalOpen(msg) {
            $('#myModalLabel').html('系统提示');
            $('#myModal .modal-body').html(msg);
            $('#myModal').modal();
        }

        function update(id, level, state, index) {
            var flag = '禁用';
            if (state == 1)
            {
                flag = '启用'
            }
            Ewin.confirm({ message: "确认要"+flag+"吗？" }).on(function (e) {
                if (!e) {
                    return;
                }
                $.post('index.php?/admin/user/setState/', {'id': id, 'level':level, 'opt':state}, function(data){
                    if (data.r == 2)
                    {
                        var row = $('#data').bootstrapTable(('getRowByUniqueId'), id);
                        row.state = state;
                        modalOpen('设置成功');
                        $('#data').bootstrapTable('updateRow',{index:index,row:row});
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
    </script>