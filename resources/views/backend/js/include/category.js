function changestatus(status,cid) {
    var msg1, msg2 = '';
    if( status == 1 ){
        msg1 = "启用";
        msg2 = "禁用";
    }else{
        msg1 = "禁用";
        msg2 = "启用";
    }

    layer.confirm( "当前状态为【" + msg1 + "】，是否更改为【" + msg2 + "】？", function(){
        $.ajax({
            type:"post",
            url:"/backend/category/changestatus",
            dataType:'json',
            headers:{'X-CSRF-TOKEN':$('input[name="_token"]').val()},
            data:{'cid':cid, 'status':status},
            success:function(data){
                if(data.status == 0)
                {
                    layer.msg( data.msg );

                }else{
                    layer.msg( data.msg ,function () {
                        window.location.reload();
                    });
                }

            },
            error:function (data) {
                layer.msg(data.msg);
            }
        });
    });
}

function addcategory() {
    var c_name  = $.trim( $('#c_name').val() );
    var parents_id  = $.trim( $('#parents_id').val() );
    var url = $.trim( $('#url').val() );
    var priority = $.trim( $('#priority').val() );
    var status  = $.trim( $('#status').val() );

    if(c_name == '')
    {
        layer.msg('分类名称不能为空');
        return false;
    }
    if(url == '')
    {
        layer.msg('链接不能为空');
        return false;
    }
    if(priority == '')
    {
        layer.msg('排序不能为空');
        return false;
    }
    if( $.inArray(status, ['0', '1']) == -1){
        layer.msg("状态异常");
        return false;
    }
    $.ajax({
        type:"post",
        url:"/backend/category/addcategory",
        dataType:'json',
        headers:{'X-CSRF-TOKEN':$('input[name="_token"]').val()},
        data:$("#form1").serialize(),
        success:function(data){
            if(data.status == 0)
            {
                layer.msg( data.msg );
            }else{
                layer.msg( data.msg ,function () {
                    window.parent.location.reload();
                    window.location.close();
                });
            }
        },
        error:function (data) {
            layer.msg(data.msg);
        }
    });
}

function opennewcategory() {
    var index = layer.open({
        type: 2,
        title: "添加分类",
        closeBtn: 0,
        area: ['700px', '400px'], //宽高
        shadeClose: true,
        resize:false,
        content: '/backend/category/addcategory/'
    });
}

function delcategory(cid){
    layer.confirm("是否真的删除分类？", function() {
        $.ajax({
            type: "delete",
            url: "/backend/category/delete/" + cid,
            dataType: 'json',
            headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()},
            success: function (data) {
                if (data.status == 0) {
                    layer.msg(data.msg);

                } else {
                    layer.msg( data.msg ,function () {
                        window.location.reload();
                    });
                }
                return false;
            },
            error: function (data) {
                layer.msg(data.msg);
                return false;
            }
        });
    });
}

function editcategoryprocess(cid) {
    var c_name  = $.trim( $('#c_name').val() );
    var parents_id  = $.trim( $('#parents_id').val() );
    var url = $.trim( $('#url').val() );
    var priority = $.trim( $('#priority').val() );
    var status  = $.trim( $('#status').val() );

    if(c_name == '')
    {
        layer.msg('分类名称不能为空');
        return false;
    }
    if(url == '')
    {
        layer.msg('链接不能为空');
        return false;
    }
    if(priority == '')
    {
        layer.msg('排序不能为空');
        return false;
    }
    if( $.inArray(status, ['0', '1']) == -1){
        layer.msg("状态异常");
        return false;
    }
    $.ajax({
        type:"post",
        url:"/backend/category/editcategory/" + cid,
        dataType:'json',
        headers:{'X-CSRF-TOKEN':$('input[name="_token"]').val()},
        data:$("#form1").serialize(),
        success:function(data){
            if(data.status == 0)
            {
                layer.msg( data.msg );
            }else{
                layer.msg( data.msg ,function () {
                    window.parent.location.reload();
                    window.location.close();
                });
            }
        },
        error:function (data) {
            layer.msg(data.msg);
        }
    });

}

function editcategory(cid) {
    var index = layer.open({
        type: 2,
        title: "修改分类",
        closeBtn: 0,
        area: ['700px', '400px'], //宽高
        shadeClose: true,
        resize:false,
        content: '/backend/category/editcategory/'+ cid
    });
}