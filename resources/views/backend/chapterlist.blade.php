@extends("backend.layout.layout")
@section("content")
    <script type="text/javascript" src="<?php echo asset( "/resources/views/backend/js/include/chapter.js?ver=1.0"); ?>"></script>
    <section class="Hui-article-box">
        <div class="Hui-article">
            <input type="hidden" id="hid_tid" value="0" />
            <article class="cl pd-20">
                <div class="text-c">
                    <form id="frm_admin" action="/backend/manhua/chapterlist/0" method="post" >
                        {{csrf_field()}}
                        <input type="text" class="input-text" style="width:250px" placeholder="输入漫画ID" id="seach_uname" name="searchword" value="">
                        <button type="submit" class="btn btn-success radius" id="btn_seach" name="btn_seach">
                            <i class="Hui-iconfont">&#xe665;</i> 搜
                        </button>
                    </form>
                </div>

                <div class="cl pd-5 bg-1 bk-gray mt-20">
                <span class="l">
                    <a href="javascript:;" id="btn_add_category" class="btn btn-primary radius" onclick="opennewchapter();">
                        <i class="Hui-iconfont">&#xe600;</i> 添加漫画章节
                    </a>
                </span>
                </div>

                <div class="mt-20">
                    <table class="table table-border table-bordered table-hover table-bg table-sort">
                        <thead>
                        <tr class="text-c">
                            <th width="50">漫画章节ID</th>
                            <th width="50">排序</th>
                            <th width="100">章节封面</th>
                            <th width="100">章节名字</th>
                            <th width="80">所属漫画</th>
                            <th width="50">显示/不显示</th>
                            <th width="50">VIP才能观看</th>
                            <th width="50">上一页</th>
                            <th width="50">下一页</th>
                            <th width="70">金币数</th>
                            <th width="70">观看数</th>
                            <th width="80">更新时间</th>
                            <th width="80">入库时间</th>
                            <th width="100">操作</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($datas as $data)
                            <tr class="text-c">
                                <td>{{$data['chapter_id']}}</td>
                                <td>{{$data['priority']}}</td>
                                <td><img src="{{$data['chapter_cover']}}" style="width:50px;" /></td>
                                <td><a style="color:red;" href="/backend/manhua/viewchapterphotos/{{$data['chapter_id']}}" target="_blank">{{$data['chapter_name']}}</a></td>
                                <td>{{$data['name']}}</td>
                                <td>@if($data['status']==1) 显示 @else 不显示 @endif</td>
                                <td>@if($data['vip']==1)  需要 @else 不需要 @endif</td>
                                <td>{{$data['pre_chapter_id']}}</td>
                                <td>{{$data['next_chapter_id']}}</td>
                                <td>{{$data['coin']}}</td>
                                <td>{{$data['views']}}</td>
                                <td>{{$data['updated_at']}}</td>
                                <td>{{$data['created_at']}}</td>
                                <td class="td-manage">
                                    <a title="编辑" href="javascript:editchapter({{$data['chapter_id']}})" class="ml-5"
                                       style="text-decoration:none">
                                        <i class="Hui-iconfont">&#xe6df;</i></a>

                                    @if($data['status'] == 0)
                                    <input type="button" onclick="opensavephoto({{$data['chapter_id']}})" class="btn btn-primary  radius" value="图片入库 ">
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="ml-12" style="text-align: center;">
                    {{ $datas->links() }}
                </div>
            </article>
        </div>

        <hr />

    </section>
    <script>
        function editchapter(chapter_id) {
            var index = layer.open({
                type: 2,
                title: "修改漫画章节:"+chapter_id,
                closeBtn: 0,
                area: ['700px', '600px'], //宽高
                shadeClose: true,
                resize:false,
                content: '/backend/manhua/editchapter/'+chapter_id
            });
        }
    </script>



@endsection