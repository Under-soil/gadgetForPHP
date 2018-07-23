<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<style>
    .table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td {
        border: solid #cccccc 1px !important;
    }
</style>
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">为<span style="color:red"><?php echo $group_data['title']; ?></span>分配权限</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <form id="rule" onsubmit="return false;">
                <input type="hidden" name="id" value="<?php echo $group_data['id']; ?>">
                <table class="table  table-bordered">
                    <tbody>
                    <?php foreach ($rule_data as $v) {
                        if(empty($v['_data'])) { ?>
                            <tr>
                                <th style="width: 10%">
                                    <label><?php echo $v['title']; ?> <input type="checkbox" name="rule_ids[]" value="<?php echo $v['id'] ?>" <?php if(in_array($v['id'],$group_data['rules'])) echo 'checked="checked"'; ?>   onclick="checkAll(this)" ></label>
                                </th>
                                <td>
                                </td>
                            </tr>
                        <?php } else { ?>
                            <tr>
                                <th>
                                    <label><?php echo $v['title']; ?> <input type="checkbox" name="rule_ids[]" value="<?php echo $v['id']; ?>" <?php if(in_array($v['id'],$group_data['rules'])) echo 'checked="checked"'; ?> onclick="checkAll(this)"></label>
                                </th>
                                <td>
                                    <?php foreach ($v['_data'] as $n){ ?>
                                        <table class="table table-bordered">
                                            <tr>
                                                <th style="width: 10%">
                                                    <label><?php echo $n['title']; ?> <input type="checkbox" name="rule_ids[]" value="<?php echo $n['id']; ?>" <?php if(in_array($n['id'],$group_data['rules'])) echo 'checked="checked"'; ?> onclick="checkAll(this)"></label>
                                                </th>
                                                <td style="text-align: left">
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
                            <input class="btn btn-info" id="btnSubmit" type="submit"  value="提交">
                        </td>
                    </tr>
                    </tbody>
                </table>
                </form>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
    <script>
        function checkAll(obj){
            $(obj).parents('.b-group').eq(0).find("input[type='checkbox']").prop('checked', $(obj).prop('checked'));
        }
        $(document).ready(function () {
            $('#btnSubmit').on('click', function () {
                var param = $('#rule').serialize();
                $.post('<?=site_url()?>/admin/group/deal', param, function(data){
                    if (data.r == 2)
                    {
                        Ewin.alert({message:'分配成功'});
                    }
                    else if (data.r == 1000)
                    {
                        window.top.location.reload();
                    }
                    else
                    {
                        Ewin.alert({message:data.m});
                    }
                }, "json");
            });
        });
    </script>
