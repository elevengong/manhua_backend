function changestatus(status,daili_id) {
    var msg1, msg2 = '';
    if( status == 1 ){
        msg1 = "正常";
        msg2 = "冻结";
    }else{
        msg1 = "正常";
        msg2 = "冻结";
    }
    layer.confirm( "当前该代理状态为【" + msg1 + "】，是否更改为【" + msg2 + "】？", function(){
        $.ajax({
            type:"post",
            url:"/backend/daili/changestatus",
            dataType:'json',
            headers:{'X-CSRF-TOKEN':$('input[name="_token"]').val()},
            data:{'daili_id':daili_id, 'status':status},
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

function resetpwd(daili_id,daili_name) {
    layer.prompt( { title: "请输入代理'"+daili_name+"'新密码", formType: 0 }, function( upwd, index ){
        if( !isUname(upwd) || !( upwd.length >= 6 && upwd.length <= 20 ) ){
            layer.msg("请输入字母、数字组成的6-20位的密码");
            return false;
        }

        $.ajax({
            type:"post",
            url:"/backend/daili/changepwd",
            dataType:'json',
            headers:{'X-CSRF-TOKEN':$('input[name="_token"]').val()},
            data:{pwd: upwd,daili_id:daili_id},
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

function adddailiprocess() {
    var daili_name  = $.trim( $('#daili_name').val() );
    var pwd  = $.trim( $('#pwd').val() );
    var commission_rate = $.trim( $('#commission_rate').val() );
    var status  = $.trim( $('#status').val() );

    if(daili_name == '')
    {
        layer.msg('代理名称不能为空');
        return false;
    }
    if(pwd == '')
    {
        layer.msg('密码不能为空');
        return false;
    }
    if( $.inArray(status, ['0', '1']) == -1){
        layer.msg("状态异常");
        return false;
    }
    if(commission_rate > 1)
    {
        layer.msg("佣金比例不正确");
        return false;
    }
    $.ajax({
        type:"post",
        url:"/backend/daili/adddaili",
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

function opennewdaili() {
    var index = layer.open({
        type: 2,
        title: "新增代理",
        closeBtn: 0,
        area: ['700px', '400px'], //宽高
        shadeClose: true,
        resize:false,
        content: '/backend/daili/adddaili/'
    });
}
