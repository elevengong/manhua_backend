<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />

    <link href="<?php echo asset( "/resources/views/backend/static/h-ui/css/H-ui.min.css") ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo asset( "/resources/views/backend/static/h-ui.admin/css/H-ui.login.css") ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo asset( "/resources/views/backend/static/h-ui.admin/css/style.css") ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo asset( "/resources/views/backend/static/Hui-iconfont/1.0.8/iconfont.css") ?>" rel="stylesheet" type="text/css" />

    <title>添加分类</title>
    <meta name="keywords" content="添加分类">
    <meta name="description" content="添加分类">
</head>
<body>
<script type="text/javascript" src="<?php echo asset( "/resources/views/backend/js/jquery.min.1.9.1.js") ?>"></script>
<script type="text/javascript" src="<?php echo asset( "/resources/views/backend/js/My97DatePicker/4.8/WdatePicker.js"); ?>"></script>
<script type="text/javascript" src="<?php echo asset( "/resources/views/backend/js/layer/layer.js") ?>"></script>

<script type="text/javascript" src="<?php echo asset( "/resources/views/backend/js/include/deposit.js?ver=1.1"); ?>"></script>
<div id="frm_account" class="col-xs-12" style="text-align: center;">
    <form class="form form-horizontal" id="form1">
        {{csrf_field()}}
        <div class="col-xs-12 row cl">
            <label class="form-label col-xs-3 col-sm-3">订单ID：</label>
            <div class="col-xs-9 col-sm-9">
                {{$order['deposit_id']}}
            </div>
        </div>
        <div class="col-xs-12 row cl">
            <label class="form-label col-xs-3 col-sm-3">用户名：</label>
            <div class="col-xs-9 col-sm-9">
                {{$order['user_name']}}
            </div>
        </div>
        <div class="col-xs-12 row cl">
            <label class="form-label col-xs-3 col-sm-3">订单号</label>
            <div class="col-xs-9 col-sm-9">
                {{$order['order_no']}}
            </div>
        </div>
        <div class="col-xs-12 row cl">
            <label class="form-label col-xs-3 col-sm-3">订单金额：</label>
            <div class="col-xs-9 col-sm-9">
                {{$order['order_money']}}
            </div>
        </div>
        <div class="col-xs-12 row cl">
            <label class="form-label col-xs-3 col-sm-3">购买什么：</label>
            <div class="col-xs-9 col-sm-9">
                {{$newType[$order['order_type']]}}
            </div>
        </div>

        <div class="col-xs-12 row cl">
            <label class="form-label col-xs-3 col-sm-3">支付类型：</label>
            <div class="col-xs-9 col-sm-9">
                @if($order['pay_type']==1) 支付宝 @else 微信 @endif
            </div>
        </div>
        <div class="col-xs-12 row cl">
            <label class="form-label col-xs-3 col-sm-3">支付用户名：</label>
            <div class="col-xs-9 col-sm-9">
                {{$order['pay_name']}}
            </div>
        </div>
        <div class="col-xs-12 row cl">
            <label class="form-label col-xs-3 col-sm-3">订单创建时间：</label>
            <div class="col-xs-9 col-sm-9">
                {{$order['created_at']}}
            </div>
        </div>
        <div class="col-xs-12 row cl">
            <label class="form-label col-xs-3 col-sm-3">IP：</label>
            <div class="col-xs-9 col-sm-9">
                {{$order['ip']}}
            </div>
        </div>

        <div class="col-xs-12 row cl">
            <label class="form-label col-xs-3 col-sm-3">付款状态：</label>
            <div class="col-xs-9 col-sm-9">
                <select name="status" style="float:left;" id="status">
                    <option value="1" @if($order['status']==1)selected="selected" @endif>确认付款</option>
                    <option value="0" @if($order['status']==0)selected="selected" @endif>等待付款</option>
                </select>
            </div>
        </div>

        <div class="col-xs-12 row cl">
            <label class="form-label col-xs-3 col-sm-3">备注：</label>
            <div class="col-xs-9 col-sm-9">
                <input type="text" class="input-text" value="{{$order['remark']}}" id="remark" name="remark" />
            </div>
        </div>



        <div class="col-xs-12 row cl" style="text-align: center;">
            <div class="formControls col-xs-12 col-sm-12">
                <input type="button" onclick="depositbyadminprocess({{$order['deposit_id']}})" class="btn btn-primary" value="手工确认" id="btn_add_ok" />
            </div>
        </div>

    </form>
</div>

<script>
    function depositbyadminprocess(deposit_id) {
        var remark  = $.trim( $('#remark').val() );
        var status  = $.trim( $('#status').val() );

        if(remark == '')
        {
            layer.msg('备注不能为空');
            return false;
        }
        if(status == 0)
        {
            layer.msg('手工确认收款，状态不能为0');
            return false;
        }

        $.ajax({
            type:"post",
            url:"/backend/money/verifydepositbyadmin/"+deposit_id,
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
</script>



</body>
</html>
