layui.use(['element','layer'], function() {
  var $ = layui.jquery,
    element = layui.element(),
    layer = layui.layer;

    $('#btn-toggle').click(function () {
       $('.layui-side').toggleClass('hidden');
    });
  //添加tab
  $('.layui-nav .layui-nav-item > a').each(function() {
    var $obj = $(this);
    var url = $obj.data('url'); //tab内容的地址
    //获取设定的url
    if(url !== undefined) {
      //给nav绑定事件
      $obj.on('click', function() {
        var layid = url.replace(/^index\.php\?\//, '');
          $.ajax({
              url: url,
              async:false,
              type:'post',
              dataType:'html',
              success:function(data) {
                  $('#body-content').html(data);
                  if($("#body-content").hasClass('layui-body-content')) $('#btn-toggle').click();
              }
          });
      });
    }
  });
  //侧边导航
  $('.layui-side .layui-nav-title').click(function() {
    var stop_item = $(this).attr('nav-item-num');
    var nav_item_icon = $(this).find('.layui-icon');
    if($(this).hasClass('item-hide')) {
      $(this).nextAll('.layui-nav-item').slice(0, stop_item).slideToggle(100);
      $(this).addClass('item-show').removeClass('item-hide');
      nav_item_icon.css('transform', 'rotate(0deg)');
    } else if($(this).hasClass('item-show')) {
      $(this).nextAll('.layui-nav-item').slice(0, stop_item).slideToggle(100);
      $(this).addClass('item-hide').removeClass('item-show');
      nav_item_icon.css('transform', 'rotate(-180deg)');
    }
  });

})

