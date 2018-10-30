function opennewchapter() {
    var index = layer.open({
        type: 2,
        title: "添加分类",
        closeBtn: 0,
        area: ['700px', '600px'], //宽高
        shadeClose: true,
        resize:false,
        content: '/backend/manhua/addchapter/'
    });
}

function addchapterprocess() {
    var chapter_name  = $.trim( $('#chapter_name').val() );
    var manhua_id = $.trim( $('#manhua_id').val() );

    if(chapter_name == '')
    {
        layer.msg('漫画章节标题不能为空');
        return false;
    }
    if(manhua_id == '')
    {
        layer.msg('漫画ID不能为空');
        return false;
    }

    $.ajax({
        type:"post",
        url:"/backend/manhua/addchapter",
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


function upload(obj){
    var id = $(obj).attr("id");
    var animateimg = $(obj).val();//获取上传的图片名 带//
    var imgarr=animateimg.split('\\'); //分割
    var myimg=imgarr[imgarr.length-1]; //去掉 // 获取图片名
    var houzui = myimg.lastIndexOf('.'); //获取 . 出现的位置
    var ext = myimg.substring(houzui, myimg.length).toUpperCase();  //切割 . 获取文件后缀

    var file = $(obj).get(0).files[0]; //获取上传的文件
    var fileSize = file.size;           //获取上传的文件大小
    var maxSize = 1048576;              //最大1MB
    if(ext !='.PNG' && ext !='.GIF' && ext !='.JPG' && ext !='.JPEG' && ext !='.BMP'){
        layer.msg('文件类型错误,请上传图片类型');
        return false;
    }else if(parseInt(fileSize) >= parseInt(maxSize)){
        layer.msg('上传的文件不能超过1MB');
        return false;
    }else{
        var data = new FormData($('#form1')[0]);

        $.ajax({
            headers:{'X-CSRF-TOKEN':$('input[name="_token"]').val()},
            url: "/backend/uploadphoto/"+id,
            type: 'POST',
            data: data,
            //data:{'data':data, 'id':id},
            dataType: 'JSON',
            cache: false,
            processData: false,
            contentType: false,
            success:function(data){
                if(data.status == 0)
                {
                    layer.msg( data.msg );

                }else{
                    //window.location.reload();
                    var result = '<img id="img" src="'+data.pic+'" width="80">';
                    $('#show').html(result);
                    $('#chapter_cover').val(data.pic);

                }

            },
            error:function (data) {
                layer.msg(data.msg);

            }
        });
        return false;
    }
}

function opensavephoto(chapter_id) {
    var index = layer.open({
        type: 2,
        title: "添加图片",
        closeBtn: 0,
        area: ['700px', '600px'], //宽高
        shadeClose: true,
        resize:false,
        content: '/backend/manhua/savechapterphotos/'+chapter_id
    });
}

function savechapterphotos(chapter_id) {
    $('#btn_add_ok').attr('disabled','disabled');

    $.ajax({
        type:"post",
        url:"/backend/manhua/savechapterphotos/"+chapter_id,
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

function editchapterprocess(chapter_id) {
    var chapter_name  = $.trim( $('#chapter_name').val() );
    var priority = $.trim( $('#priority').val() );
    // var vip  = $.trim( $('#vip').val() );
    var pre_chapter_id  = $.trim( $('#pre_chapter_id').val() );
    var next_chapter_id  = $.trim( $('#next_chapter_id').val() );
    var coin  = $.trim( $('#coin').val() );
    var views  = $.trim( $('#views').val() );

    if(chapter_name == '')
    {
        layer.msg('漫画章节名不能为空');
        return false;
    }
    if(priority == '')
    {
        layer.msg('排序不能为空');
        return false;
    }
    if(pre_chapter_id == '')
    {
        layer.msg('上一页不能为空');
        return false;
    }
    if(next_chapter_id == '')
    {
        layer.msg('next_chapter_id');
        return false;
    }
    if(coin == '')
    {
        layer.msg('金币不能为空');
        return false;
    }

    $.ajax({
        type:"post",
        url:"/backend/manhua/editchapter/"+chapter_id,
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