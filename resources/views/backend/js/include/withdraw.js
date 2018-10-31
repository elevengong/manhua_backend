function closeorder(withdraw_id) {
    layer.confirm("是否关闭ID号为： "+withdraw_id+" 的订单？", function() {
        $.ajax({
            type: "delete",
            url: "/backend/money/closeorder/" + withdraw_id,
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

function comfirmorder(withdraw_id) {
    var index = layer.open({
        type: 2,
        title: "修改漫画",
        closeBtn: 0,
        area: ['700px', '600px'], //宽高
        shadeClose: true,
        resize:false,
        content: '/backend/money/comfirmorder/'+withdraw_id
    });
}