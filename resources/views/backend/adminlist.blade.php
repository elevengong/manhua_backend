@extends("backend.layout.layout")
@section("content")
    <script type="text/javascript" src="<?php echo asset( "/resources/views/backend/js/include/admin.js?ver=1.0"); ?>"></script>
    <section class="Hui-article-box">
        <div class="Hui-article">
            <input type="hidden" id="hid_tid" value="0" />
            <article class="cl pd-20">

                <div class="text-c">
                    <form id="frm_admin" action="/backend/adminlist" method="post" >
                        {{csrf_field()}}
                        <input type="text" class="input-text" style="width:250px" placeholder="输入管理员名" id="seach_uname" name="searchword" value="">
                        <button type="submit" class="btn btn-success radius" id="btn_seach" name="btn_seach">
                            <i class="Hui-iconfont">&#xe665;</i> 搜
                        </button>
                    </form>
                </div>

                <div class="cl pd-5 bg-1 bk-gray mt-20">
                <span class="l">
                    <a href="javascript:;" id="btn_add_account" class="btn btn-primary radius">
                        <i class="Hui-iconfont">&#xe600;</i> 添加管理员
                    </a>
                </span>
                </div>

                <div class="mt-20">
                    <table class="table table-border table-bordered table-hover table-bg table-sort">
                        <thead>
                        <tr class="text-c">
                            <th width="80">管理员名</th>
                            <th width="100">创建时间</th>
                            <th width="100">最后登录时间</th>
                            <th width="80">最后登录IP</th>
                            <th width="70">是否禁用</th>
                            <th width="100">操作</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($datas as $data)
                        <tr class="text-c">
                            <td>{{$data['name']}}</td>
                            <td>{{$data['created_at']}}</td>
                            <td>{{$data['lastlogined_at']}}</td>
                            <td>{{$data['login_ip']}}</td>
                            <td>
                                <input type="button" onclick="changelock_user('{{$data['status']}}','{{$data['admin_id']}}')" class="btn btn-@if($data['status'] ==0)warning @elseif($data['status'] ==1)primary @endif radius" value="@if($data['status'] ==1)启用 @else 禁用 @endif"  />
                            </td>
                            <td class="td-manage">

                                <a title="删除" href="javascript:del_admin('{{$data['admin_id']}}')" class="ml-5"
                                   style="text-decoration:none">
                                    <i class="Hui-iconfont">&#xe6e2;</i>
                                </a>

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

    <div id="frm_account" class="col-xs-12" style="text-align: center; display: none;">
        <form class="form form-horizontal">
            <div class="col-xs-12 row cl">
                <label class="form-label col-xs-3 col-sm-3">管理员名：</label>
                <div class="col-xs-9 col-sm-9">
                    <input type="text" class="input-text" value="" id="txt_add_uname" name="txt_add_uname" />
                </div>
            </div>

            <div class="col-xs-12 row cl">
                <label class="form-label col-xs-3 col-sm-3">密码：</label>
                <div class="col-xs-9 col-sm-9">
                    <input type="password" class="input-text" value="" id="txt_add_upwd" name="txt_add_upwd" />
                </div>
            </div>

            <div class="col-xs-12 row cl" style="text-align: center;">
                <div class="formControls col-xs-12 col-sm-12">
                    <input type="button" onclick="add_ok('{{csrf_token()}}')" class="btn btn-primary" value="确定" id="btn_add_ok" />
                    <input type="button" onclick="add_clear()" class="btn btn-primary" value="取消" id="btn_add_clear" />
                </div>
            </div>

        </form>
    </div>


@endsection