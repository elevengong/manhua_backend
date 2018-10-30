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
    <div style="color: red;font-size: 25px;">注意：请把要上传的图片上传到/public/chapter_temporary/目录下</div>
    <form class="form form-horizontal" id="form1">
        {{csrf_field()}}
        <div class="col-xs-12 row cl">
            <input type="hidden" class="input-text" value="{{$info['manhua_id']}}" id="manhua_id" name="manhua_id" />
            <label class="form-label col-xs-3 col-sm-3">漫画名称：</label>
            <div class="col-xs-9 col-sm-9">
                <input type="text" class="input-text" disabled="disabled" value="{{$info['name']}}" id="manhua_name" name="manhua_name" />
            </div>
        </div>
        <div class="col-xs-12 row cl">
            <label class="form-label col-xs-3 col-sm-3">漫画章节名称：</label>
            <div class="col-xs-9 col-sm-9">
                <input type="text" class="input-text" disabled="disabled" value="{{$info['chapter_name']}}" id="chapter_name" name="chapter_name" />
            </div>
        </div>
        <div class="col-xs-12 row cl">
            <label class="form-label col-xs-3 col-sm-3">漫画章节ID：</label>
            <div class="col-xs-9 col-sm-9">
                <input type="text" class="input-text" disabled="disabled" value="{{$chapter_id}}" id="chapter_id" name="chapter_id" />
            </div>
        </div>
        <div class="col-xs-12 row cl" style="text-align: center;">
            <div class="formControls col-xs-12 col-sm-12">
                <input type="button" onclick="savechapterphotos({{$chapter_id}});" class="btn btn-primary" value="添加章节漫画" id="btn_add_ok" />
            </div>
        </div>

    </form>
</div>

<script>


</script>



</body>
</html>
