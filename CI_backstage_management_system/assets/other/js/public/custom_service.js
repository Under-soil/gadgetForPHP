 function do_edit() {
        var enable_create_table   = $('input[name="enable_create_table"]:checked').val();
        layer.confirm('确认要修改吗？', {icon: 3, title:'提示'}, function(index){
            $.post('index.php?/tool/custom_service/save',
                {
                    'enable_create_table'   : enable_create_table,
                },
                function(data){
                    if (data.r)
                    {
                        layer.alert("设置成功！");
                        refresh('index.php?/tool/custom_service/index');
                    }
                    else
                    {
                        layer.alert(data.m);
                        cancel();
                    }
                },"json");

            layer.close(index);
        });
}
