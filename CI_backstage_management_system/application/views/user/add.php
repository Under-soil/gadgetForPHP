<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
    <div class="col-xs-12">
        <div class="tabbable">
            <ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab">
                <li class="active"><a href="#home" data-toggle="tab">添加用户</a></li>
            </ul>
            <div class="tab-content">
                    <!-- PAGE CONTENT BEGINS -->
                <h1 class="text-center">为<span style="color:red"><?php echo $group_data['title']; ?></span>添加用户</h1>
                <div class="space-4"></div>
                    <form class="form-horizontal" role="form" id="add" action="#" onsubmit="return false;">
                        <input type="hidden" name="level" value="<?php echo $group_data['id']; ?>">
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1">用户名</label>
                            <div class="col-sm-9">
                                <input type="text"  name="username" id="username" placeholder="用户名"  lay-verify="username"  class="col-xs-10 col-sm-5">
                            </div>
                        </div>
                        <div class="space-4"></div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 密码 </label>

                            <div class="col-sm-9">
                                <input type="password" name="passwd" id="passwd" lay-verify="passwd" placeholder="密码"  class="col-xs-10 col-sm-5">
                                <span class="help-inline col-xs-12 col-sm-7">
											</span>
                            </div>
                        </div>
                        <div class="clearfix form-actions">
                            <div class="col-md-offset-3 col-md-9">
                                <button class="btn btn-info" type="submit" lay-submit lay-filter="add">
                                    <i class="ace-icon fa fa-check bigger-110"></i>
                                    提交
                                </button>
                                <button class="btn" type="reset">
                                    <i class="ace-icon fa fa-undo bigger-110"></i>
                                    重置
                                </button>
                            </div>
                        </div>
                    </form>
            </div>
        </div>
    </div>
<script src="<?php echo $this->config->item('statics_path'); ?>/other/js/public/user_add.js"></script>
