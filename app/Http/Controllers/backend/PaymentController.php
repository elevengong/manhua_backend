<?php

namespace App\Http\Controllers\backend;

use App\Model\OrderDeposit;
use App\Model\Paymentaccount;
use function cli\input;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\MyController;

class PaymentController extends MyController
{
    public function pay(Request $request){
        $deposit_id = request()->input('id');
        $order_money = request()->input('money');
        $order_no = request()->input('order_no');
        //验证
        if(empty($deposit_id) or empty($order_money) or empty($order_no)){
            $re['msg'] = "Error1";
            return json_encode($re);
        }else{
            $orderDetail = OrderDeposit::find($deposit_id);
            if(empty($orderDetail)){
                $re['msg'] = "Error2";
                return json_encode($re);
            }else{
                if($orderDetail->order_money != $order_money or $orderDetail->order_no != $order_no){
                    $re['msg'] = "Error3";
                    return json_encode($re);
                }else{
                    $account = Paymentaccount::find(1);
                    return view('backend.paymentform',compact('account','order_money','order_no'));
                }
            }
        }

    }

    public function paymentpage(Request $request){
        if($request->isMethod('post')){
            $optEmail = request()->input('optEmail');
            $payAmount = request()->input('payAmount');
            $title = request()->input('title');
            return view('backend.paymentpage',compact('optEmail','payAmount','title'));
        }else{
            echo "Error!";exit;
        }
    }

    public function callBack(Request $request){
        if($request->isMethod('post')){
            $aa = request()->input('title');
            



        }else{
            echo 'Error';exit;
        }

    }
}
