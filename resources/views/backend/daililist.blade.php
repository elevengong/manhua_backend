@extends("backend.layout.layout")
@section("content")
    <script type="text/javascript" src="<?php echo asset( "/resources/views/backend/js/include/daili.js?ver=1.0"); ?>"></script>
    <section class="Hui-article-box">
        <div class="Hui-article">
            <input type="hidden" id="hid_tid" value="0" />
            <article class="cl pd-20">
                <div class="text-c">
                    <form id="frm_admin" action="/backend/user/list" method="post" >
                        {{csrf_field()}}
                        <input type="text" class="input-text" style="width:250px" placeholder="输入代理名" id="seach_uname" name="searchword" value="">
                        <button type="submit" class="btn btn-success radius" id="btn_seach" name="btn_seach">
                            <i class="Hui-iconfont">&#xe665;</i> 搜
                        </button>
                    </form>
                </div>
                <div class="cl pd-5 bg-1 bk-gray mt-20">
                <span class="l">
                    <a href="javascript:;" id="btn_add_category" class="btn btn-primary radius" onclick="opennewdaili();">
                        <i class="Hui-iconfont">&#xe600;</i> 新增代理
                    </a>
                </span>
                </div>

                <div class="mt-20">
                    <table class="table table-border table-bordered table-hover table-bg table-sort">
                        <thead>
                        <tr class="text-c">
                            <th width="40">代理ID</th>
                            <th width="50">代理名</th>
                            <th width="30">status</th>
                            <th width="70">支付宝</th>
                            <th width="50">支付宝名</th>
                            <th width="70">微信</th>
                            <th width="50">微信名</th>
                            <th width="50">可用佣金</th>
                            <th width="50">冻结佣金</th>
                            <th width="50">佣金比例</th>
                            <th width="50">最近登陆IP</th>
                            <th width="50">最近登陆时间</th>
                            <th width="100">操作</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($datas as $data)
                            <tr class="text-c">
                                <td>{{$data['daili_id']}}</td>
                                <td><a href="#{{$data['daili_id']}}" title="查询{{$data['daili_name']}}代理下的用户" style="color: red;">{{$data['daili_name']}}</a></td>
                                <td>
                                    <input type="button" onclick="changestatus('{{$data['status']}}','{{$data['daili_id']}}');" class="btn btn-@if($data['status'] ==0)warning @elseif($data['status'] ==1)primary @endif radius" value="@if($data['status'] ==1)正常 @else 已冻结 @endif"  />
                                </td>
                                <td>{{$data['alipay']}}</td>
                                <td>{{$data['alipay_name']}}</td>
                                <td>{{$data['weixin']}}</td>
                                <td>{{$data['weixin_name']}}</td>
                                <td>{{$data['current_commision']}}</td>
                                <td>{{$data['frzon_commision']}}</td>
                                <td>{{$data['commission_rate']}}</td>
                                <td>{{$data['login_ip']}}</td>
                                <td>{{$data['last_login_time']}}</td>
                                <td class="td-manage">
                                    <input type="button" onclick="resetpwd('{{$data['daili_id']}}','{{$data['daili_name']}}');" class="btn btn-primary  radius" value="重设密码 ">
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