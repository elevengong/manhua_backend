@extends("backend.layout.layout")
@section("content")
    <script type="text/javascript" src="<?php echo asset( "/resources/views/backend/js/include/attribute.js?ver=1.1"); ?>"></script>
    <section class="Hui-article-box">
        <div class="Hui-article">
            <input type="hidden" id="hid_tid" value="0" />
            <article class="cl pd-20">
                {{csrf_field()}}
                <div class="cl pd-5 bg-1 bk-gray mt-20">
                <span class="l">
                    <a href="javascript:;" id="btn_add_account" class="btn btn-primary radius" onclick="openstatic();">
                        <i class="Hui-iconfont">&#xe600;</i> 添加静态属性
                    </a>
                </span>
                </div>

                <div class="mt-20">
                    <table class="table table-border table-bordered table-hover table-bg table-sort">
                        <thead>
                        <tr class="text-c">
                            <th width="80">ID</th>
                            <th width="100">属性名称</th>
                            <th width="80">Value</th>
                            <th width="100">操作</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($datas as $data)
                            <tr class="text-c">
                                <td>{{$data['id']}}</td>
                                <td>{{$data['name']}}</td>
                                <td>{{$data['value']}}</td>
                                <td class="td-manage">
                                    <a title="编辑" href="javascript:edit_static({{$data['id']}})" class="ml-5"
                                       style="text-decoration:none">
                                        <i class="Hui-iconfont">&#xe6df;</i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>


            </article>
        </div>

        <hr />

    </section>
    <script>

    </script>



@endsection