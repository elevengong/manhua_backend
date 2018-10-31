<?php

namespace App\Http\Controllers\backend;

use App\Model\Daili;
use App\Model\OrderWithdraw;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\MyController;
use Illuminate\Support\Facades\DB;

class WithdrawController extends MyController
{
    public function withdrawlist(Request $request){
        if($request->isMethod('post')){
            $searchword = request()->input('searchword');
            $orders = OrderWithdraw::select('orderwithdraw.*','daili.daili_name')
                ->leftJoin('daili',function ($join){
                    $join->on('daili.daili_id','=','orderwithdraw.daili_id');
                })->where('daili.daili_name','like','%'.$searchword.'%')
                ->orderBy('orderwithdraw.created_at', 'desc')->paginate($this->backendPageNum);

        }else{
            $orders = OrderWithdraw::select('orderwithdraw.*','daili.daili_name')
                ->leftJoin('daili',function ($join){
                    $join->on('daili.daili_id','=','orderwithdraw.daili_id');
                })
                ->orderBy('orderwithdraw.created_at', 'desc')->paginate($this->backendPageNum);
        }
        return view('backend.withdrawlist',compact('orders'))->with('admin', session('admin'));

    }

    public function closeorder(Request $request,$withdraw_id){
        if($request->isMethod('delete')){

            DB::beginTransaction();
            try {
                $OrderDetail = OrderWithdraw::where('withdraw_id', $withdraw_id)->lockForUpdate()->get()->toArray();
                $dailiDetail = Daili::where('daili_id', $OrderDetail[0]['daili_id'])->lockForUpdate()->get()->toArray();

                $current_commision = $dailiDetail[0]['current_commision'] + $OrderDetail[0]['withdraw_money'];
                $frzon_commision = $dailiDetail[0]['frzon_commision'] - $OrderDetail[0]['withdraw_money'];

                $re = OrderWithdraw::where('withdraw_id',$withdraw_id)->update(['status' => 2]);
                $re1 = Daili::where('daili_id',$OrderDetail[0]['daili_id'])->update(['current_commision' => $current_commision, 'frzon_commision' => $frzon_commision]);
                if($re and $re1)
                {
                    DB::commit();
                    $data['status'] = 1;
                    $data['msg'] = "成功关闭该订单";
                }else{
                    DB::rollBack();
                    $data['status'] = 0;
                    $data['msg'] = "关闭订单失败";
                }
                echo json_encode($data);

            }catch (\Exception $e) {
                DB::rollBack();
                $data['status'] = 0;
                $data['msg'] = "Error!";
                echo json_encode($data);
            }

        }
    }

    public function comfirmorder(Request $request,$withdraw_id){
        if($request->isMethod('post')){
            $status = request()->input('status');
            $remark = request()->input('remark');
            $transfer_no = request()->input('transfer_no');

            DB::beginTransaction();
            try {
                $OrderDetail = OrderWithdraw::where('withdraw_id', $withdraw_id)->lockForUpdate()->get()->toArray();
                $dailiDetail = Daili::where('daili_id', $OrderDetail[0]['daili_id'])->lockForUpdate()->get()->toArray();

                $re = OrderWithdraw::where('withdraw_id',$withdraw_id)->update(['status' => $status, 'remark' => $remark, 'transfer_no' => $transfer_no]);

                $frzon_commision = $dailiDetail[0]['frzon_commision'] - $OrderDetail[0]['withdraw_money'];
                $re1 = Daili::where('daili_id',$OrderDetail[0]['daili_id'])->update(['frzon_commision' => $frzon_commision]);

                if($re and $re1)
                {
                    DB::commit();
                    $data['status'] = 1;
                    $data['msg'] = "成功付款";
                }else{
                    DB::rollBack();
                    $data['status'] = 0;
                    $data['msg'] = "付款失败";
                }
                echo json_encode($data);

            }catch (\Exception $e) {
                DB::rollBack();
                $data['status'] = 0;
                $data['msg'] = "Error!";
                echo json_encode($data);
            }

        }else{
            $order = OrderWithdraw::select('orderwithdraw.*','daili.daili_name')
                ->leftJoin('daili',function ($join){
                    $join->on('daili.daili_id','=','orderwithdraw.daili_id');
                })->where('withdraw_id',$withdraw_id)->get()->toArray();
            return view('backend.comfirmorder')->with('order',$order[0]);
        }

    }









}
