@extends("backend.layout.layout")
@section("content")
    <script type="text/javascript" src="<?php echo asset( "/resources/views/backend/js/include/manhua.js?ver=1.0"); ?>"></script>
    <section class="Hui-article-box">
        <div class="Hui-article">
            <input type="hidden" id="hid_tid" value="0" />
            <article class="cl pd-20">
                <div class="text-c">
                    <form id="frm_admin" action="/backend/manhua/manhualist" method="post" >
                        {{csrf_field()}}
                        <input type="text" class="input-text" style="width:250px" placeholder="输入漫画" id="seach_uname" name="searchword" value="">
                        <button type="submit" class="btn btn-success radius" id="btn_seach" name="btn_seach">
                            <i class="Hui-iconfont">&#xe665;</i> 搜
                        </button>
                    </form>
                </div>

                <div class="cl pd-5 bg-1 bk-gray mt-20">
                <span class="l">
                    <a href="javascript:;" id="btn_add_category" class="btn btn-primary radius" onclick="opennewmanhua();">
                        <i class="Hui-iconfont">&#xe600;</i> 添加漫画
                    </a>
                </span>
                </div>

                <div class="mt-20">
                    <table class="table table-border table-bordered table-hover table-bg table-sort">
                        <thead>
                        <tr class="text-c">
                            <th width="80">漫画ID</th>
                            <th width="100">漫画封面</th>
                            <th width="100">漫画名</th>
                            <th width="80">分类</th>
                            <th width="70">作者</th>
                            <th width="70">简介</th>
                            <th width="70">观看数</th>
                            <th width="70">完结/连载</th>
                            <th width="70">显示/不显示</th>
                            <th width="70">更新时间</th>
                            <th width="70">入库时间</th>
                            <th width="100">操作</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($datas as $data)
                            <tr class="text-c">
                                <td>{{$data['manhua_id']}}</td>
                                <td><img src="{{$data['cover']}}" style="width:50px;" /></td>
                                <td>{{$data['name']}}</td>
                                <td>{{$data['c_name']}}</td>
                                <td>{{$data['author']}}</td>
                                <td>{{$data['intro']}}</td>
                                <td>{{$data['views']}}</td>
                                <td>@if($data['finish']==1) 完结 @else 连载 @endif</td>
                                <td>@if($data['status']==1) 显示 @else 不显示 @endif</td>
                                <td>{{$data['last_update_time']}}</td>
                                <td>{{$data['created_at']}}</td>
                                <td class="td-manage">
                                    <a title="编辑" href="javascript:editmanhua({{$data['manhua_id']}})" class="ml-5"
                                       style="text-decoration:none">
                                        <i class="Hui-iconfont">&#xe6df;</i>

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

    </script>



@endsection