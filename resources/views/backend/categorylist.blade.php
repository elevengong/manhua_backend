@extends("backend.layout.layout")
@section("content")
    <script type="text/javascript" src="<?php echo asset( "/resources/views/backend/js/include/category.js?ver=1.0"); ?>"></script>
    <section class="Hui-article-box">
        <div class="Hui-article">
            <input type="hidden" id="hid_tid" value="0" />
            <article class="cl pd-20">
                {{csrf_field()}}
                <div class="cl pd-5 bg-1 bk-gray mt-20">
                <span class="l">
                    <a href="javascript:;" id="btn_add_category" class="btn btn-primary radius" onclick="opennewcategory();">
                        <i class="Hui-iconfont">&#xe600;</i> 添加分类
                    </a>
                </span>
                </div>

                <div class="mt-20">
                    <table class="table table-border table-bordered table-hover table-bg table-sort">
                        <thead>
                        <tr class="text-c">
                            <th width="80">分类ID</th>
                            <th width="100">分类名</th>
                            <th width="100">父ID</th>
                            <th width="80">Url</th>
                            <th width="70">排序</th>
                            <th width="70">status</th>
                            <th width="70">更新时间</th>
                            <th width="100">操作</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($datas as $data)
                            <tr class="text-c">
                                <td>{{$data['cid']}}</td>
                                <td>{{$data['c_name']}}</td>
                                <td>{{$data['parents_id']}}</td>
                                <td>{{$data['url']}}</td>
                                <td>{{$data['priority']}}</td>
                                <td>
                                    <input type="button" onclick="changestatus('{{$data['status']}}','{{$data['cid']}}')" class="btn btn-@if($data['status'] ==0)warning @elseif($data['status'] ==1)primary @endif radius" value="@if($data['status'] ==1)启用中 @else 已禁用 @endif"  />
                                </td>
                                <td>{{$data['updated_at']}}</td>
                                <td class="td-manage">

                                    <a title="删除" href="javascript:delcategory('{{$data['cid']}}')" class="ml-5"
                                       style="text-decoration:none">
                                        <i class="Hui-iconfont">&#xe6e2;</i>
                                    </a>
                                    <a title="编辑" href="javascript:editcategory({{$data['cid']}})" class="ml-5"
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