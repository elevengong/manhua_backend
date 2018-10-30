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

    <title>后台登陆</title>
    <meta name="keywords" content="后台登陆">
    <meta name="description" content="后台登陆">
</head>
<body>
<script type="text/javascript" src="<?php echo asset( "/resources/views/backend/js/jquery.min.1.9.1.js") ?>"></script>
<script type="text/javascript" src="<?php echo asset( "/resources/views/backend/js/My97DatePicker/4.8/WdatePicker.js"); ?>"></script>
<script type="text/javascript" src="<?php echo asset( "/resources/views/backend/js/layer/layer.js") ?>"></script>
<script type="text/javascript" src="<?php echo asset( "/resources/views/backend/js/include/chapter.js?ver=1.0"); ?>"></script>
<div id="frm_account" class="col-xs-12" style="text-align: center;">
    <form class="form form-horizontal" id="form1">
        {{csrf_field()}}
        <div class="col-xs-12 row cl">
            <label class="form-label col-xs-3 col-sm-3">漫画章节标题：</label>
            <div class="col-xs-9 col-sm-9">
                <input type="text" class="input-text" value="" id="chapter_name" name="chapter_name" />
            </div>
        </div>
        <div class="col-xs-12 row cl">
            <label class="form-label col-xs-3 col-sm-3">漫画ID：</label>
            <div class="col-xs-9 col-sm-9">
                <input type="text" class="input-text" value="" id="manhua_id" name="manhua_id" />
            </div>
        </div>
        <div class="col-xs-12 row cl">
            <label class="form-label col-xs-3 col-sm-3">显示：</label>
            <div class="col-xs-9 col-sm-9">
                <select name="status" style="float:left;" id="status">
                    <option value="1">显示</option>
                    <option value="0" selected="selected">不显示</option>
                </select>
            </div>
        </div>
        <div class="col-xs-12 row cl">
            <label class="form-label col-xs-3 col-sm-3">是否VIP才能观看：</label>
            <div class="col-xs-9 col-sm-9">
                <select name="vip" style="float:left;" id="vip">
                    <option value="1" selected="selected">是</option>
                    <option value="0">不是</option>
                </select>
            </div>
        </div>
        <div class="col-xs-12 row cl">
            <label class="form-label col-xs-3 col-sm-3">章节封面：</label>
            <div class="col-xs-9 col-sm-9">
                <input type="button" value="上传图片" onclick="photo1.click()" style="float:left;margin-top:10px;" class="btn_mouseout"/>
                <p><input type="file" id="photo1" name="photo1" onchange="upload(this);" style="display:none" /></p>
                <div id="show" style="float:left;padding-left:7px;"></div>
                <input type="hidden" id="chapter_cover" name="chapter_cover" value="">
            </div>
        </div>
        <div class="col-xs-12 row cl">
            <label class="form-label col-xs-3 col-sm-3">金币数：</label>
            <div class="col-xs-9 col-sm-9">
                <input type="text" class="input-text" value="10" id="coin" name="coin" />
            </div>
        </div>
        <div class="col-xs-12 row cl">
            <label class="form-label col-xs-3 col-sm-3">观看次数：</label>
            <div class="col-xs-9 col-sm-9">
                <input type="text" class="input-text" value="{{rand(100,999)}}" id="views" name="views" />
            </div>
        </div>

        <div class="col-xs-12 row cl" style="text-align: center;">
            <div class="formControls col-xs-12 col-sm-12">
                <input type="button" onclick="addchapterprocess();" class="btn btn-primary" value="添加漫画章节" id="btn_add_ok" />
            </div>
        </div>

    </form>
</div>

<script>

</script>



</body>
</html>
