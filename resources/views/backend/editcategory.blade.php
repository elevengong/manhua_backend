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

<script type="text/javascript" src="<?php echo asset( "/resources/views/backend/js/include/category.js?ver=1.1"); ?>"></script>
<div id="frm_account" class="col-xs-12" style="text-align: center;">
    <form class="form form-horizontal" id="form1">
        {{csrf_field()}}
        <div class="col-xs-12 row cl">
            <label class="form-label col-xs-3 col-sm-3">分类名称：</label>
            <div class="col-xs-9 col-sm-9">
                <input type="text" class="input-text" value="{{$categoryDate['c_name']}}" id="c_name" name="c_name" />
            </div>
        </div>
        <div class="col-xs-12 row cl">
            <label class="form-label col-xs-3 col-sm-3">分类级别：</label>
            <div class="col-xs-9 col-sm-9">
                <select name="parents_id" style="float:left;" id="parents_id">
                    <option value="0" @if($categoryDate['parents_id']==0) selected="selected" @endif>一级分类</option>
                    @foreach($firstCategoryArray as $category)
                        <option value="{{$category['cid']}}" @if($categoryDate['parents_id']==$category['cid']) selected="selected" @endif>{{$category['c_name']}}--添加到这个分类下</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-xs-12 row cl">
            <label class="form-label col-xs-3 col-sm-3">URL：</label>
            <div class="col-xs-9 col-sm-9">
                <input type="text" class="input-text" value="{{$categoryDate['url']}}" id="url" name="url" />
            </div>
        </div>
        <div class="col-xs-12 row cl">
            <label class="form-label col-xs-3 col-sm-3">状态：</label>
            <div class="col-xs-9 col-sm-9">
                <select name="status" style="float:left;" id="status">
                    <option value="1" selected="selected">启用</option>
                    <option value="0">禁用</option>
                </select>
            </div>
        </div>
        <div class="col-xs-12 row cl">
            <label class="form-label col-xs-3 col-sm-3">排序：</label>
            <div class="col-xs-9 col-sm-9">
                <input type="text" class="input-text" value="{{$categoryDate['priority']}}" id="priority" name="priority" />
            </div>
        </div>

        <div class="col-xs-12 row cl" style="text-align: center;">
            <div class="formControls col-xs-12 col-sm-12">
                <input type="button" onclick="editcategoryprocess({{$categoryDate['cid']}})" class="btn btn-primary" value="修改分类" id="btn_add_ok" />
            </div>
        </div>

    </form>
</div>

<script>

</script>



</body>
</html>
