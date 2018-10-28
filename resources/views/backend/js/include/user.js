function changestatus(status,uid) {
    var msg1, msg2 = '';
    if( status == 1 ){
        msg1 = "正常";
        msg2 = "冻结";
    }else{
        msg1 = "正常";
        msg2 = "冻结";
    }
    layer.confirm( "当前该会员状态为【" + msg1 + "】，是否更改为【" + msg2 + "】？", function(){
        $.ajax({
            type:"post",
            url:"/backend/user/changestatus",
            dataType:'json',
            headers:{'X-CSRF-TOKEN':$('input[name="_token"]').val()},
            data:{'uid':uid, 'status':status},
            success:function(data){
                if(data.status == 0)
                {
                    layer.msg( data.msg );
                    return false;
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

function changepwd(uid,username) {
    layer.prompt( { title: "请输入会员'"+username+"'新密码", formType: 0 }, function( upwd, index ){
        if( !isUname(upwd) || !( upwd.length >= 6 && upwd.length <= 20 ) ){
            layer.msg("请输入字母、数字组成的6-20位的密码");
            return false;
        }

        $.ajax({
            type:"post",
            url:"/backend/user/changepwd",
            dataType:'json',
            headers:{'X-CSRF-TOKEN':$('input[name="_token"]').val()},
            data:{pwd: upwd,uid:uid},
            success:function(data){
                if(data.status == 0)
                {
                    layer.msg( data.msg );

                }else{
                    layer.msg( data.msg ,function () {
                        layer.close(index);
                    });
                }

            },
            error:function (data) {
                layer.msg("修改失败");
                layer.close(index);
            }
        });
    });
}