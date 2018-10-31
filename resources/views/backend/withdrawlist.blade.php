@extends("backend.layout.layout")
@section("content")
    <script type="text/javascript" src="<?php echo asset( "/resources/views/backend/js/include/withdraw.js?ver=1.0"); ?>"></script>
    <section class="Hui-article-box">
        <div class="Hui-article">
            <input type="hidden" id="hid_tid" value="0" />
            <article class="cl pd-20">
                <div class="text-c">
                    <form id="frm_admin" action="/backend/money/applywithdrawlist" method="post" >
                        {{csrf_field()}}
                        <input type="text" class="input-text" style="width:250px" placeholder="输入代理名" id="seach_uname" name="searchword" value="">
                        <button type="submit" class="btn btn-success radius" id="btn_seach" name="btn_seach">
                            <i class="Hui-iconfont">&#xe665;</i> 搜
                        </button>
                    </form>
                </div>

                <div class="mt-20">
                    <table class="table table-border table-bordered table-hover table-bg table-sort">
                        <thead>
                        <tr class="text-c">
                            <th width="50">提款ID号</th>
                            <th width="50">代理名</th>
                            <th width="50">订单号</th>
                            <th width="50">金额</th>
                            <th width="50">提款信息</th>
                            <th width="50">订单状态</th>
                            <th width="50">交易号</th>
                            <th width="50">备注</th>
                            <th width="50">处理时间</th>
                            <th width="50">创建时间</th>
                            <th width="100">操作</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($orders as $data)
                            <tr class="text-c">
                                <td>{{$data['withdraw_id']}}</td>
                                <td>{{$data['daili_name']}}</td>
                                <td>{{$data['order_no']}}</td>
                                <td>{{$data['withdraw_money']}}</td>
                                <td>{{$data['withdraw_info']}}</td>
                                <td>@if($data['status']==0) 等待付款 @elseif($data['status']==1) 已付款 @elseif($data['status']==2) 已关闭 @elseif($data['status']==3) 已取消 @endif</td>
                                <td>{{$data['transfer_no']}}</td>
                                <td>{{$data['remark']}}</td>
                                <td>{{$data['deal_time']}}</td>
                                <td>{{$data['created_at']}}</td>
                                <td>&nbsp;
                                    @if($data['status']==0)
                                        <input type="button" onclick="comfirmorder({{$data['withdraw_id']}})" class="btn btn-primary  radius" value="确认支付">
                                        <input type="button" onclick="closeorder({{$data['withdraw_id']}})" class="btn btn-primary  radius" value="关闭订单">
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