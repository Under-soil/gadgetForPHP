<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
    <div class="col-xs-12">
        <div class="tabbable">
            <ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab">
                <li class="active"><a href="#home" data-toggle="tab">权限列表</a></li>
                <li><a href="javascript:;" onclick="add()">添加权限</a></li>
            </ul>
            <div class="tab-content">
                <form class="" id="order" action="" method="post">
                    <table id="searchTable" class="table table-striped table-bordered table-hover table-condensed">
                        <tr>
                            <th w_align="left" w_index="id" style="text-align: left">节点</th>
                            <th w_align="left" w_render="show_input" width="5%" style="text-align: left">父节点</th>
                            <th w_align="left" w_index="_name" style="text-align: left">权限名</th>
                            <th w_align="left"  w_index="name" style="text-align: left">权限</th>
                            <th w_align="left" w_render="operate" style="text-align: left">操作</th>
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
                    <h4 class="modal-title" id="myModalLabel"> 添加权限</h4>
                </div>
                <div class="modal-body">
                    <form id="form-form" class="form-inline"  action="#" onsubmit="return false;">
                        <input type="hidden" name="pid" value="0">
                        <table class="table table-striped table-bordered table-hover table-condensed">
                            <tr>
                                <th width="12%">
                                    权限名：
                                </th>
                                <td>
                                    <input class="input-medium" type="text" name="title" maxlength="20">
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    权限：
                                </th>
                                <td>
                                    <input class="input-medium" type="text" name="name" maxlength="20">输入模块/控制器/方法即可(全小写) 例如 admin/rule/index
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    图标：
                                </th>
                                <td>
                                    <input class="input-medium" type="text" name="ico" maxlength="80">
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    排序：
                                </th>
                                <td>
                                    <input class="input-medium" type="text" name="order_number" maxlength="3">
                                </td>
                            </tr>
                            <tr>
                                <th>
                                </th>
                                <td>
                                    <input class="btn btn-success" type="submit" lay-submit lay-filter="ruleadd" value="添加">
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
                    <h4 class="modal-title" id="myModalLabel"> 修改权限</h4>
                </div>
                <div class="modal-body">
                    <form id="edit-form" class="form-inline"  action="#" onsubmit="return false;">
                        <input type="hidden" name="id">
                        <table class="table table-striped table-bordered table-hover table-condensed">
                            <tr>
                                <th width="12%">
                                    权限名：
                                </th>
                                <td>
                                    <input class="input-medium" type="text" name="title" maxlength="20">
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    权限：
                                </th>
                                <td>
                                    <input class="input-medium" type="text" name="name" maxlength="80"> 输入模块/控制器/方法即可(全小写) 例如 admin/rule/index
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    图标：
                                </th>
                                <td>
                                    <input class="input-medium" type="text" name="ico" maxlength="80">
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    排序：
                                </th>
                                <td>
                                    <input class="input-medium" type="text" name="order_number" maxlength="3">
                                </td>
                            </tr>
                            <tr>
                                <th>
                                </th>
                                <td>
                                    <input class="btn btn-success" type="submit" lay-submit lay-filter="ruleedit" value="修改">
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>

<!--rule.js 权限管理页面效验和提交-->
<script src="<?php echo $this->config->item('statics_path'); ?>/other/js/public/rule.js"></script>