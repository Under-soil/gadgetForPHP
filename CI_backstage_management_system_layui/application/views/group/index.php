<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
    <div class="col-xs-12">
        <div class="tabbable">
            <ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab">
                <li class="active"><a href="#home" data-toggle="tab">用户组列表</a></li>
                <li><a href="javascript:;" onclick="add()">添加用户组</a></li>
            </ul>
            <div class="tab-content">
                <form class="" action="" method="post">
                    <table id="searchTable" class="table table-striped table-bordered table-hover table-condensed">
                        <tr>
                            <th class="text-left" w_align="left" w_index="id" style="text-align: left">级别</th>
                            <th class="text-left" w_align="left" w_index="title" style="text-align: left">用户组名</th>
                            <th class="text-left" w_align="left" w_render="operate" style="text-align: left">操作</th>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="form-add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times;</button>
                    <h4 class="modal-title" id="myModalLabel"> 添加用户组</h4>
                </div>
                <div class="modal-body">
                    <form id="add" class="form-inline" action="#" onsubmit="return false;">
                        <table class="table table-striped table-bordered table-hover table-condensed">
                            <tr>
                                <th width="15%">
                                    用户组名：
                                </th>
                                <td>
                                    <input class="input-medium" type="text" name="title">
                                </td>
                            </tr>
                            <tr>
                                <th>
                                </th>
                                <td>
                                    <input class="btn btn-success" type="submit" lay-submit lay-filter="add" value="添加">
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="form-edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times;</button>
                    <h4 class="modal-title" id="myModalLabel"> 修改分组</h4>
                </div>
                <div class="modal-body">
                    <form id="edit" class="form-inline" action="#" onsubmit="return false;">
                        <input type="hidden" name="id">
                        <table class="table table-striped table-bordered table-hover table-condensed">
                            <tr>
                                <th width="12%">
                                    分组名：
                                </th>
                                <td>
                                    <input class="input-medium" type="text" name="title">
                                </td>
                            </tr>
                            <tr>
                                <th>
                                </th>
                                <td>
                                    <input class="btn btn-success" type="submit" lay-submit lay-filter="edit" value="修改">
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>

<!--group.js 用户组管理页面效验和提交-->
<script src="<?php echo $this->config->item('statics_path'); ?>/other/js/public/group.js"></script>