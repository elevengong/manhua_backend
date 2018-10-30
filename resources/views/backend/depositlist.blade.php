@extends("backend.layout.layout")
@section("content")
    <script type="text/javascript" src="<?php echo asset( "/resources/views/backend/js/include/deposit.js?ver=1.0"); ?>"></script>
    <section class="Hui-article-box">
        <div class="Hui-article">
            <input type="hidden" id="hid_tid" value="0" />
            <article class="cl pd-20">
                <div class="text-c">
                    <form id="frm_admin" action="backend/money/applydepositlist" method="post" >
                        {{csrf_field()}}
                        <input type="text" class="input-text" style="width:250px" placeholder="输入用户名" id="seach_uname" name="searchword" value="">
                        <button type="submit" class="btn btn-success radius" id="btn_seach" name="btn_seach">
                            <i class="Hui-iconfont">&#xe665;</i> 搜
                        </button>
                    </form>
                </div>

                <div class="mt-20">
                    <table class="table table-border table-bordered table-hover table-bg table-sort">
                        <thead>
                        <tr class="text-c">
                            <th width="50">订单ID</th>
                            <th width="40">用户名</th>
                            <th width="50">代理ID</th>
                            <th width="50">金额</th>
                            <th width="50">订单号</th>
                            <th width="50">购买选项</th>
                            <th width="50">交易单号</th>
                            <th width="50">付款类型</th>
                            <th width="50">付款名字</th>
                            <th width="50">IP</th>
                            <th width="50">status</th>
                            <th width="50">是否已经结算给代理</th>
                            <th width="50">备注</th>
                            <th width="50">处理时间</th>
                            <th width="50">创建时间</th>
                            <th width="100">操作</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($orders as $data)
                            <tr class="text-c">
                                <td>{{$data['deposit_id']}}</td>
                                <td>{{$data['user_name']}}</td>
                                <td>@if($data['daili_id']==0) 不用结算 @else {{$data['daili_id']}}  @endif</td>
                                <td>{{$data['order_money']}}</td>
                                <td>{{$data['order_no']}}</td>
                                <td>{{$newType[$data['order_type']]}}</td>
                                <td>{{$data['transfer_no']}}</td>
                                <td>@if($data['pay_type']==1) 支付宝 @else 微信 @endif</td>
                                <td>{{$data['pay_name']}}</td>
                                <td>{{$data['ip']}}</td>
                                <td>@if($data['status']==0) <em style="color: green;">等待付款</em> @else <em style="color: red;">已付款</em>  @endif</td>
                                <td>@if($data['pay_daili']==0) 未结算 @else 已结算 @endif</td>
                                <td>{{$data['remark']}}</td>
                                <td>{{$data['deal_time']}}</td>
                                <td>{{$data['created_at']}}</td>
                                <td>&nbsp;
                                    @if($data['status']==0)
                                    <input type="button" onclick="depositbyadmin({{$data['deposit_id']}})" class="btn btn-primary  radius" value="手动确认">
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>

                <div class="ml-12" style="text-align: center;">
                    {{ $orders->links() }}
                </div>


            </article>
        </div>

        <hr />

    </section>
    <script>

    </script>



@endsection