@extends("backend.layout.layout")
@section("content")
    <script type="text/javascript" src="<?php echo asset( "/resources/views/backend/js/include/member.js?ver=1.2"); ?>"></script>
    <section class="Hui-article-box">
        <div class="Hui-article">
            <input type="hidden" id="hid_tid" value="0" />
            <article class="cl pd-20">

                <div class="text-c">
                    <form id="frm_admin" action="/backend/member/sitemember" method="post" >
                        {{csrf_field()}}
                        <input type="text" class="input-text" style="width:250px" placeholder="输入广告主" id="member" name="member" value="">
                        <button type="submit" class="btn btn-success radius" id="btn_seach" name="btn_seach">
                            <i class="Hui-iconfont">&#xe665;</i> 搜
                        </button>
                    </form>
                </div>

                <div class="mt-20">
                    <table class="table table-border table-bordered table-hover table-bg table-sort">
                        <thead>
                        <tr class="text-c">
                            <th width="50">ID</th>
                            <th width="50">站长</th>
                            <th width="50">QQ</th>
                            <th width="50">余额</th>
                            <th width="50">冻结</th>
                            <th width="50">个人扣量</th>
                            <th width="50">状态</th>
                            <th width="50">最后登录时间</th>
                            <th width="50">最后登录IP</th>
                            <th width="50">帐号创建时间</th>
                            <th width="100">操作</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($MemberArray as $data)
                            <tr class="text-c">
                                <td>{{$data['member_id']}}</td>
                                <td>{{$data['name']}}</td>
                                <td>{{$data['qq']}}</td>
                                <td>{{$data['balance']}}</td>
                                <td>{{$data['frozen']}}</td>
                                <td>{{$data['personal_rate']}}</td>
                                <td>
                                    <input type="button" onclick="changememberstatus('{{$data['status']}}','{{$data['member_id']}}')" class="btn btn-@if($data['status'] ==0)warning @elseif($data['status'] ==1)primary @endif radius" value="@if($data['status'] ==1)正常 @else 冻结 @endif"  />
                                </td>
                                <td>{{$data['lastlogined_at']}}</td>
                                <td>{{$data['login_ip']}}</td>
                                <td>{{$data['created_at']}}</td>
                                <td class="td-manage">
                                    <input type="button" onclick="resetmemberpwd('{{$data['member_id']}}','{{$data['name']}}','站长')" class="btn btn-primary radius" value="重设密码" />
                                    <input type="button" onclick="setpersonalrate('{{$data['member_id']}}','{{$data['personal_rate']}}','{{$data['name']}}')" class="btn btn-primary radius" value="设置扣量"  />
                                    <input type="button" onclick="memberwithdraw()" class="btn btn-primary radius" value="提款记录"  />
                                    <input type="button" onclick="membersites()" class="btn btn-primary radius" value="会员网站"  />
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>

                <div class="ml-12" style="text-align: center;">
                    {{ $MemberArray->links() }}
                </div>


            </article>
        </div>

        <hr />

    </section>
    <script>

    </script>



@endsection