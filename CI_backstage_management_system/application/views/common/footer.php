<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
</div>
</div>
</div>
</div>
<script src="<?php echo $this->config->item('statics_path'); ?>/aceadmin/js/bootstrap.min.js"></script>
<script src="<?php echo $this->config->item('statics_path'); ?>/aceadmin/js/ace-elements.min.js"></script>
<script src="<?php echo $this->config->item('statics_path'); ?>/aceadmin/js/ace.min.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item('statics_path'); ?>/bsgrid/js/lang/grid.zh-CN.min.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item('statics_path'); ?>/bsgrid/merged/bsgrid.all.min.js"></script>
<script src="<?php echo $this->config->item('statics_path'); ?>/aceadmin/js/bootbox.js"></script>
<script>
    $(function () {
        $('.b-has-child .active').parents('.b-has-child').eq(0).find('.b-nav-parent').click();
    })
    $('.b-nav-li > a').click(function () {
        var url = $(this).attr('href');
        $('.b-nav-li > a').css('color', 'black');
        $(this).css('color', '#4b88b7');
        var title = $(this).parent().parent().parent().children().first().data('title') + '>' + $(this).data('title');
        $('.bread_crumb').html(title);
        refresh(url);
        if ($('#menu-toggler').is(":visible"))
        {
            $("#sidebar").toggleClass("display");
            $('#menu-toggler').toggleClass("display");
        }
        return false;
    });

    function refresh(url) {
        $.ajax({
            url: url,
            async:true,
            type:'post',
            dataType:'html',
            success:function(data) {
                if(!data.match("^\{(.+:.+,*){1,}\}$"))
                {
                    $('.page-content').html(data);
                } else {
                    var obj = eval('(' + data + ')');
                    if (obj.r == 1000)
                    {
                        window.top.location.reload();
                    } else
                    {
                        bootbox.alert(obj.m);
                    }
                }
            }
        });
    }
</script>
</body>
</html>
