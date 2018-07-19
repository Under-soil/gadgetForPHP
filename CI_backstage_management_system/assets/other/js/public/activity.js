
//图片上传
var xhr;
function createXMLHttpRequest() {

    if (window.ActiveXObject) {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    } else if (window.XMLHttpRequest) {
        xhr = new XMLHttpRequest();
    }
}
function UpladFile() {
    var fileObj = document.getElementById("file").files[0];
    var FileController = 'upload.php';
    var form = new FormData();
    form.append("myfile", fileObj);
    createXMLHttpRequest();
    xhr.onreadystatechange = handleStateChange;
    xhr.open("post", FileController, true);
    xhr.send(form);
}
function handleStateChange() {
    if (xhr.readyState == 4) {
        if (xhr.status == 200 || xhr.status == 0) {
            var result = xhr.responseText;
            var json = eval("(" + result + ")");
            // alert('上传成功');
        }
    }
}

var gridObj;
$(function () {
    gridObj = $.fn.bsgrid.init('searchTable', {
        url: 'index.php?/tool/activity/data/',
        dataType: 'json',
        // pageSize: 20,
        stripeRows:true,//隔行换色
        rowHoverColor:true,// 划过行变色
        displayBlankRows:false,//是否显示空白行,
        pageSizeSelect:false,
        showPageToolbar:true
    });
});
function status(record) {
    if (record.status == 0)
    {
        return '活动';
    }
    return '公告';
}

function operate(record, rowIndex, colIndex, options) {
    var opt = [];
    if (record.locking != 1)
    {
        opt.push('<a href="javascript:setstate( 1, '+record.id+');"  >启用</a> | ');
    }
    else
    {
        opt.push('<a href="javascript:setstate( 0, '+record.id+');"  >禁用</a> | ');
    }
    opt.push('<a href="javascript:;" navId="'+record.id+'" navCode="'+record.code+'" navName="'+record.name+'" navStatus="'+record.status+'"  navChaetosema="'+record.chaetosema+' "' +
        ' navLink="'+record.link+'" navTextfield="'+record.textfield+'"   navContent="'+record.content+'" onclick="edit(this)">修改</a> | <a href="javascript:if(confirm(\'确定删除？\')) del('+record.id+')">删除</a>');
    return opt.join("");
}

function setstate(opt, id){
    loading = layer.load(2, {
        shade: [0.2,'#000'] //0.2透明度的白色背景
    });

    var param = {"id":id, "opt":opt};
    $.post('index.php?/tool/activity/setstate/', param, function(data){
        layer.close(loading);
        if (data.r == 4000)
        {
            gridObj.refreshPage();
            layer.closeAll('page');
        }
        else if (data.r == 1000)
        {
            top.document.location.reload();
        }
        else
        {
            layer.msg(data.m, {icon: 2, anim: 6, time: 1000});
        }
    }, "json");
}

function del(id) {
    $.post('index.php?/tool/activity/delete', {'id': id}, function(data){
        if (data.r == 4000)
        {
            layer.msg('删除成功', {icon: 1, anim: 6, time: 1000});
            gridObj.refreshPage();
        }
        else if (data.r == 1000)
        {
            window.top.location.reload();
        }
        else
        {
            layer.msg(data.m, {icon: 2, anim: 6, time: 1000});
        }
    }, "json");
}

// 添加公告
function add(){
    $("input[name='code']").val('');
    $("input[name='name']").val('');
    $("input[name='status']").val('');
    $("input[name='chaetosema']").val('');
    $("input[name='textfield']").val('');
    $("input[name='link']").val('');
    $("input[name='file']").val('');
    $("textarea[name='content']").val('');
    $('#form-add').modal('show');
}

//修改公告
function edit(obj){
    var navId=$(obj).attr('navId'),
        navCode=$(obj).attr('navCode'),
        navName=$(obj).attr('navName'),
        navStatus=$(obj).attr('navStatus'),
        navChaetosema=$(obj).attr('navChaetosema')
    navLink=$(obj).attr('navLink')
    navTextfield=$(obj).attr('navTextfield')
    navContent=$(obj).attr('navContent')
    $("input[name='id']").val(navId);
    $("input[name='code']").val(navCode);
    $("input[name='name']").val(navName);
    $("input[name='status']").val(navStatus);
    $("input[name='chaetosema']").val(navChaetosema);
    $("input[name='link']").val(navLink);
    $("input[name='textfield']").val(navTextfield);
    $("textarea[name='content']").val(navContent);
    $('#form-edit').modal('show');
}

//生成活动ID
function make_code(){
    $.ajax({
        type:"post",
        url: 'index.php?/tool/activity/code',
        dataType:'json',
        success: function(data){
            if(data)
            {
                $("input[name=code]").val(data);
            }

        }
    });
    return false;
}


layui.use(['form', 'layer'], function(){
    var layer = layui.layer,
        $ = layui.jquery,
        form = layui.form();
    form.render();
    form.on('submit(addstore)', function(data) {
        var code = $("#code").val();
        var name = $("#name").val();
        var status = $("#status").val();
        var chaetosema = $("#chaetosema").val();
        var link = $("#link").val();
        var textfield = $("#textfield").val();
        var content = $("#content").val();
        if(code===''){
            layer.msg('公告ID不能为空', {icon: 2, anim: 6, time: 1000});
            return false;
        }
        if(name===''){
            layer.msg('公告名称不能为空', {icon: 2, anim: 6, time: 1000});
            return false;
        }
        if(/^[0-9]*$/.test(chaetosema) == false){
            layer.msg('角标格式错误', {icon: 2, anim: 6, time: 1000});
            return false;
        }
        // if(/http(s)?:\/\/([\w-]+\.)+[\w-]+(\/[\w- .\/?%&=]*)?/.test(link) == false){
        if(link===''){
            layer.msg('链接格式错误', {icon: 2, anim: 6, time: 1000});
            return false;
        }
        if(status == 0)
        {
            if(textfield===''){
                layer.msg('图片不能为空', {icon: 2, anim: 6, time: 1000});
                return false;
            }
        }else
        {
            if(content===''){
                layer.msg('内容不能为空', {icon: 2, anim: 6, time: 1000});
                return false;
            }
        }
        var param = $('#store').serialize();
        $.post('index.php?/tool/activity/store', param, function(data){
            if (data.r == 4000)
            {
                layer.msg('添加成功', {icon: 1, anim: 6, time: 1000});
                $('#detail').hide();
                $('#form-add').modal('hide');
                $('.modal-backdrop').hide();
                gridObj.refreshPage();
            }
            else if (data.r == 1000)
            {
                window.top.location.reload();
            }
            else
            {
                layer.msg(data.m, {icon: 2, anim: 6, time: 1000});
            }
        }, "json");
        return false;
    });

    form.on('submit(editsave)', function(data) {
        var param = $('#save').serialize();
        $.post('index.php?/tool/activity/save', param, function(data){
            if (data.r == 4000)
            {
                layer.msg('保存成功', {icon: 1, anim: 6, time: 1000});
                $('#form-edit').modal('hide');
                $('#detail').hide();
                gridObj.refreshPage();
            }
            else if (data.r == 1000)
            {
                window.top.location.reload();
            }
            else
            {
                layer.msg(data.m, {icon: 2, anim: 6, time: 1000});
            }
        }, "json");
        return false;
    });
});

