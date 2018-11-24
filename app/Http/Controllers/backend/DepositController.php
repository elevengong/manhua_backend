<?php

namespace App\Http\Controllers\backend;

use App\Model\Daili;
use App\Model\OrderDeposit;
use App\Model\SaleType;
use App\Model\Users;
use Illuminate\Http\Request;
use App\Http\Controllers\MyController;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;

class DepositController extends MyController
{

    public function __construct(){
//        $users = DB::table('users')->get();
//        echo "aaa";
//        print_r($users);exit;
    }

    public function depositlist(Request $request){
        $saleType = SaleType::orderBy('t_id','asc')->get()->toArray();
        $newType = array();
        foreach ($saleType as $sale)
        {
            $newType[$sale['t_id']] = $sale['name'];
        }
        if($request->isMethod('post')){
            $searchword = request()->input('searchword');
            $orders = OrderDeposit::select('orderdeposit.*','users.user_name')
                ->leftJoin('users',function ($join){
                    $join->on('users.uid','=','orderdeposit.uid');
                })->where('users.user_name','like','%'.$searchword.'%')
                ->orderBy('orderdeposit.created_at', 'desc')->paginate($this->backendPageNum);

        }else{
            $orders = OrderDeposit::select('orderdeposit.*','users.user_name')
                ->leftJoin('users',function ($join){
                    $join->on('users.uid','=','orderdeposit.uid');
                })
                ->orderBy('orderdeposit.created_at', 'desc')->paginate($this->backendPageNum);
        }
        return view('backend.depositlist',compact('orders','newType'))->with('admin', session('admin'));
    }

    public function verifydepositbyadmin(Request $request,$deposit_id){
        if($request->isMethod('post')){
            $status = request()->input('status');
            $remark = request()->input('remark');

            DB::beginTransaction();
            try {
                //行锁
                $OrderDetail = OrderDeposit::where('deposit_id', $deposit_id)->lockForUpdate()->get()->toArray();
                $UserDetail = Users::where('uid', $OrderDetail[0]['uid'])->lockForUpdate()->get()->toArray();
                if($OrderDetail[0]['daili_id'] != 0)
                {
                    $DailiDetail = Daili::where('daili_id',$OrderDetail[0]['daili_id'])->lockForUpdate()->get()->toArray();
                }

                //判断购买类型
                $type = $OrderDetail[0]['order_type'];
                switch ($type)
                {
                    case 1:
                        if($UserDetail[0]['vip']==0)
                        {
                            $vip_end_time = date("Y-m-d h:i:s", strtotime("+1 day", time()));
                        }else{
                            $vip_end_time = date("Y-m-d h:i:s", strtotime("+1 day", strtotime($UserDetail[0]['vip_end_time'])));
                        }
                        break;
                    case 2:
                        if($UserDetail[0]['vip']==0)
                        {
                            $vip_end_time = date("Y-m-d h:i:s", strtotime("+1 months", time()));
                        }else{
                            $vip_end_time = date("Y-m-d h:i:s", strtotime("+1 months", strtotime($UserDetail[0]['vip_end_time'])));
                        }
                        break;
                    case 3:
                        if($UserDetail[0]['vip']==0)
                        {
                            $vip_end_time = date("Y-m-d h:i:s", strtotime("+3 months", time()));
                        }else{
                            $vip_end_time = date("Y-m-d h:i:s", strtotime("+3 months", strtotime($UserDetail[0]['vip_end_time'])));
                        }
                        break;
                    case 4:
                        if($UserDetail[0]['vip']==0)
                        {
                            $vip_end_time = date("Y-m-d h:i:s", strtotime("+12 months", time()));
                        }else{
                            $vip_end_time = date("Y-m-d h:i:s", strtotime("+12 months", strtotime($UserDetail[0]['vip_end_time'])));
                        }
                        break;
                    default:
                        //买的金币数额
                        $coinAmount = ceil($OrderDetail[0]['order_money'] * $this->coinrate);
               }


                if($OrderDetail[0]['daili_id'] != 0){
                    $result = OrderDeposit::where('deposit_id', $deposit_id)->update(['status' => $status, 'remark' => $remark, 'deal_time'=> date('Y-m-d h:i:s',time()), 'pay_daili'=> '1']);
                }else{
                    $result = OrderDeposit::where('deposit_id', $deposit_id)->update(['status' => $status, 'remark' => $remark, 'deal_time'=> date('Y-m-d h:i:s',time())]);
                }

               if($type != 5)
               {
                   $result1 = Users::where('uid',$OrderDetail[0]['uid'])->update(['vip' => 1, 'vip_end_time'=> $vip_end_time]);
               }else{
                   $result1 = Users::where('uid',$OrderDetail[0]['uid'])->increment('coin',$coinAmount);
               }
               //留个接口，代理收款------------------------------------------------------------------------
                if($OrderDetail[0]['daili_id'] != 0){
                    $dailiMoney = $OrderDetail[0]['order_money'] * round($DailiDetail[0]['commission_rate'],2);
                    $result3 = Daili::where('daili_id',$OrderDetail[0]['daili_id'])->increment('current_commision',$dailiMoney);
                }

                if($result and $result1)
                {
                    DB::commit();
                    $data['status'] = 1;
                    $data['msg'] = "手工确认存款成功";
                    echo json_encode($data);
                }else{
                    DB::rollBack();
                    $data['status'] = 0;
                    $data['msg'] = "手工确认存款失败";
                    echo json_encode($data);
                }

            }catch (\Exception $e) {
                DB::rollBack();
                $data['status'] = 0;
                $data['msg'] = "Error!";
                echo json_encode($data);
            }


        }else{
            $saleType = SaleType::orderBy('t_id','asc')->get()->toArray();
            $newType = array();
            foreach ($saleType as $sale)
            {
                $newType[$sale['t_id']] = $sale['name'];
            }
            $order = OrderDeposit::select('orderdeposit.*','users.user_name')
                ->leftJoin('users',function ($join){
                    $join->on('users.uid','=','orderdeposit.uid');
                })
                ->where('orderdeposit.deposit_id', $deposit_id)->get()->toArray();
            return view('backend.verifydepositbyadmin',compact('newType'))->with('order',$order[0]);
        }
    }
}
