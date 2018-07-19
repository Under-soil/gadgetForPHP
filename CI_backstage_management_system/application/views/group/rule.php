<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
    <div class="col-xs-12">
        <div class="tabbable">
            <ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab">
                <li class="active"><a href="#home" data-toggle="tab">分配权限</a></li>
            </ul>
            <div class="tab-content">
                <h1 class="text-center">为<span style="color:red"><?php echo $group_data['title']; ?></span>分配权限</h1>
                <form id="rule" action="#" onsubmit="return false;">
                    <input type="hidden" name="id" value="<?php echo $group_data['id']; ?>">
                    <table class="table table-striped table-bordered table-hover table-condensed ">
                        <?php foreach ($rule_data as $v) {
                            if(empty($v['_data'])) { ?>
                                <tr class="b-group">
                                    <th width="10%">
                                        <label><?php echo $v['title']; ?> <input type="checkbox" name="rule_ids[]" value="<?php echo $v['id'] ?>" <?php if(in_array($v['id'],$group_data['rules'])) echo 'checked="checked"'; ?>   onclick="checkAll(this)" ></label>
                                    </th>
                                    <td>
                                    </td>
                                </tr>
                            <?php } else { ?>
                                <tr class="b-group">
                                    <th width="10%">
                                        <label><?php echo $v['title']; ?> <input type="checkbox" name="rule_ids[]" value="<?php echo $v['id']; ?>" <?php if(in_array($v['id'],$group_data['rules'])) echo 'checked="checked"'; ?> onclick="checkAll(this)"></label>
                                    </th>
                                    <td class="b-child">
                                        <?php foreach ($v['_data'] as $n){ ?>
                                            <table class="table table-striped table-bordered table-hover table-condensed">
                                                <tr class="b-group">
                                                    <th width="10%">
                                                        <label><?php echo $n['title']; ?> <input type="checkbox" name="rule_ids[]" value="<?php echo $n['id']; ?>" <?php if(in_array($n['id'],$group_data['rules'])) echo 'checked="checked"'; ?> onclick="checkAll(this)"></label>
                                                    </th>
                                                    <td>
                                                        <?php
                                                            if($n['_data']) {
                                                                foreach ($n['_data'] as $c) {
                                                                ?>
                                                                    <label>&emsp;<?php echo $c['title']; ?> <input type="checkbox" name="rule_ids[]" value="<?php echo $c['id']; ?>" <?php if(in_array($c['id'],$group_data['rules'])) echo 'checked="checked"'; ?> ></label>
                                                      <?php      }
                                }
                                                        ?>
                                                    </td>
                                                </tr>
                                            </table>
                                        <?php } ?>
                                    </td>
                                </tr>
                         <?php   }
                            ?>

                        <?php } ?>
                        <tr>
                            <th>
                            </th>
                            <td>
                                <input class="btn btn-success" type="submit" lay-submit lay-filter="submit" value="提交">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>

<!--group_rule.js 分配权限页面效验和提交-->
<script src="<?php echo $this->config->item('statics_path'); ?>/other/js/public/group_rule.js"></script>