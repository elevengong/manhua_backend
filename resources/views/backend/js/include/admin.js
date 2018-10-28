$(function(){

    if( $("#btn_add_account").length > 0 ) {
        $("#btn_add_account").click(function () {
            $("#hid_id").val(0);
            openaccount(0);
        });
    }

});

function openaccount(type){
    var msg = ( type == 0 ) ? "添加": "更新";
    showindex = layer.open({
        type: 1,
        title: msg + "管理员",
        closeBtn: 0,
        area: ['500px', '280px'], //宽高
        shadeClose: true,
        resize:false,
        content: $("#frm_account")
    });
}

function add_clear(){
    layer.close( showindex );
}

function add_ok(){
    var uname = $.trim( $("#txt_add_uname").val() );
    var upwd = $.trim( $("#txt_add_upwd").val() );

    if( uname == ""  ){
        layer.msg("用户名不能为空");
        return;
    }
    if( upwd == ""  ){
        layer.msg("密码不能为空");
        return;
    }

    $.ajax({
        type:"post",
        url:"/backend/admin/add",
        dataType:'json',
        headers:{'X-CSRF-TOKEN':$('input[name="_token"]').val()},
        data:{'name':uname, 'pwd':upwd},
        success:function(data){
            if(data.status == 0)
            {
                layer.msg( data.msg );

            }else{
                window.location.reload();
                layer.msg( data.msg );
            }

        },
        error:function (data) {
            layer.msg(data.msg);
        }
    });

}

function edit_admin(admin_id){
    var msg = "修改";
    var index = layer.open({
        type: 2,
        title: msg + "管理员",
        closeBtn: 0,
        area: ['550px', '480px'], //宽高
        shadeClose: true,
        resize:false,
        content: '/backend/admin/edit/'+ admin_id
    });
}

function edit_ok(admin_id){
    var admin = $.trim( $("#admin").val() );
    var nickname = $.trim( $("#nickname").val() );
    var qq = $.trim( $("#qq").val() );
    var photo_path = $.trim( $('#img').attr('src') );
    var status = $.trim( $("#status").val() );

    if( admin == ""  ){
        layer.msg("活动名不能为空");
        return;
    }
    if( nickname == ""  ){
        layer.msg("别名不能为空");
        return;
    }
    if( $.inArray(status, ['0', '1']) == -1){
        layer.msg("状态异常");
        return;
    }
    if( qq == ""  ){
        layer.msg("QQ不能为空");
        return;
    }

    $.ajax({
        type:"post",
        url:"/backend/admin/edit/"+ admin_id,
        dataType:'json',
        headers:{'X-CSRF-TOKEN':$('input[name="_token"]').val()},
        data:{'admin':admin, 'nickname':nickname, 'qq':qq, 'photo_path':photo_path, 'status':status},
        success:function(data){
            if(data.status == 0)
            {
                layer.msg( data.msg );
            }else{
                layer.msg(data.msg,function(){
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

function changelock_user( state,admin_id ){
    var msg1, msg2 = '';
    if( state == 1 ){
        msg1 = "启用";
        msg2 = "禁用";
    }else{
        msg1 = "禁用";
        msg2 = "启用";
    }

    layer.confirm( "当前状态为【" + msg1 + "】，是否更改为【" + msg2 + "】？", function(){
        $.ajax({
            type:"post",
            url:"/backend/admin/changestatus",
            dataType:'json',
            headers:{'X-CSRF-TOKEN':$('input[name="_token"]').val()},
            data:{'admin_id':admin_id, 'state':state},
            success:function(data){
                if(data.status == 0)
                {
                    layer.msg( data.msg );
                }else{
                    window.location.reload();
                    layer.msg( data.msg );
                }
            },
            error:function (data) {
                layer.msg(data.msg);
            }
        });
    });
}

function del_admin(admin_id){
    layer.confirm("是否真的删除用户？", function() {
        $.ajax({
            type: "delete",
            url: "/backend/admin/delete/" + admin_id,
            dataType: 'json',
            headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()},
            success: function (data) {
                if (data.status == 0) {
                    layer.msg(data.msg);

                } else {
                    window.location.reload();
                    layer.msg(data.msg);
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



