@extends("backend.layout.layout")
@section("content")
    <script type="text/javascript" src="<?php echo asset( "/resources/views/backend/js/include/user.js?ver=1.0"); ?>"></script>
    <section class="Hui-article-box">
        <div class="Hui-article">
            <input type="hidden" id="hid_tid" value="0" />
            <article class="cl pd-20">
                <div class="text-c">
                    <form id="frm_admin" action="/backend/user/list" method="post" >
                        {{csrf_field()}}
                        <input type="text" class="input-text" style="width:250px" placeholder="输入会员名" id="seach_uname" name="searchword" value="">
                        <button type="submit" class="btn btn-success radius" id="btn_seach" name="btn_seach">
                            <i class="Hui-iconfont">&#xe665;</i> 搜
                        </button>
                    </form>
                </div>

                <div class="mt-20">
                    <table class="table table-border table-bordered table-hover table-bg table-sort">
                        <thead>
                        <tr class="text-c">
                            <th width="40">用户ID</th>
                            <th width="50">用户名</th>
                            <th width="50">代理ID</th>
                            <th width="30">VIP</th>
                            <th width="100">VIP过期时间</th>
                            <th width="50">金币余额</th>
                            <th width="30">status</th>
                            <th width="70">注册IP</th>
                            <th width="70">最近登陆IP</th>
                            <th width="100">最近登陆时间</th>
                            <th width="100">操作</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($datas as $data)
                            <tr class="text-c">
                                <td>{{$data['uid']}}</td>
                                <td><a href="#{{$data['uid']}}" title="查询用户{{$data['user_name']}}的充值订单" style="color: red;">{{$data['user_name']}}</a></td>
                                <td>{{$data['daili_id']}}</td>
                                <td>@if($data['vip']==1)VIP @else 普通会员 @endif</td>
                                <td>{{$data['vip_end_time']}}</td>
                                <td>{{$data['coin']}}</td>
                                <td>
                                    <input type="button" onclick="changestatus('{{$data['status']}}','{{$data['uid']}}');" class="btn btn-@if($data['status'] ==0)warning @elseif($data['status'] ==1)primary @endif radius" value="@if($data['status'] ==1)正常 @else 已冻结 @endif"  />
                                </td>
                                <td>{{$data['register_ip']}}</td>
                                <td>{{$data['login_ip']}}</td>
                                <td>{{$data['last_login_time']}}</td>
                                <td class="td-manage">
                                    <input type="button" onclick="changepwd('{{$data['uid']}}','{{$data['user_name']}}');" class="btn btn-primary  radius" value="修改密码 ">
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