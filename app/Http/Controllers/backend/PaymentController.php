<?php

namespace App\Http\Controllers\backend;

use App\Model\Daili;
use App\Model\OrderDeposit;
use App\Model\Paymentaccount;
use function cli\input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $callBackDatas=$request->all();
        if(!empty($callBackDatas)){
            $this->logs($callBackDatas);
            if($request->isMethod('post')){
                $account = Paymentaccount::find(1);

                if(strtoupper(md5($account->merchant_id . $account->merchant_key . $callBackDatas['tradeNo'] . $callBackDatas['Money'] . $callBackDatas['title'] . $callBackDatas['memo'])) == strtoupper($callBackDatas['Sign'])){
                    //通过title获取订单详情
                    $orderInfo = OrderDeposit::where('order_no',$callBackDatas['title'])->get()->toArray();
                    if(!empty($orderInfo)){
                        if($orderInfo[0]['order_money'] == $callBackDatas['Money']){
                            if($orderInfo[0]['status'] == 0){
                                DB::beginTransaction();
                                try{
                                    if($orderInfo[0]['daili_id'] != 0){
                                        $result = OrderDeposit::where('deposit_id', $orderInfo[0]['deposit_id'])->update(['status' => 1, 'transfer_no' => $callBackDatas['tradeNo'], 'deal_time'=> date('Y-m-d h:i:s',time()), 'pay_daili'=> '1']);
                                    }else{
                                        $result = OrderDeposit::where('deposit_id', $orderInfo[0]['deposit_id'])->update(['status' => 1, 'transfer_no' => $callBackDatas['tradeNo'], 'deal_time'=> date('Y-m-d h:i:s',time())]);
                                    }
                                    $type = $orderInfo[0]['order_type'];
                                    switch ($type)
                                    {
                                        case 1:
                                            if($orderInfo[0]['vip']==0)
                                            {
                                                $vip_end_time = date("Y-m-d h:i:s", strtotime("+1 day", time()));
                                            }else{
                                                $vip_end_time = date("Y-m-d h:i:s", strtotime("+1 day", strtotime($orderInfo[0]['vip_end_time'])));
                                            }
                                            break;
                                        case 2:
                                            if($orderInfo[0]['vip']==0)
                                            {
                                                $vip_end_time = date("Y-m-d h:i:s", strtotime("+1 months", time()));
                                            }else{
                                                $vip_end_time = date("Y-m-d h:i:s", strtotime("+1 months", strtotime($orderInfo[0]['vip_end_time'])));
                                            }
                                            break;
                                        case 3:
                                            if($orderInfo[0]['vip']==0)
                                            {
                                                $vip_end_time = date("Y-m-d h:i:s", strtotime("+3 months", time()));
                                            }else{
                                                $vip_end_time = date("Y-m-d h:i:s", strtotime("+3 months", strtotime($orderInfo[0]['vip_end_time'])));
                                            }
                                            break;
                                        case 4:
                                            if($orderInfo[0]['vip']==0)
                                            {
                                                $vip_end_time = date("Y-m-d h:i:s", strtotime("+12 months", time()));
                                            }else{
                                                $vip_end_time = date("Y-m-d h:i:s", strtotime("+12 months", strtotime($orderInfo[0]['vip_end_time'])));
                                            }
                                            break;
                                        default:
                                            //买的金币数额
                                            $coinAmount = ceil($orderInfo[0]['order_money'] * $this->coinrate);
                                    }
                                    if($type != 5)
                                    {
                                        $result1 = Users::where('uid',$orderInfo[0]['uid'])->update(['vip' => 1, 'vip_end_time'=> $vip_end_time]);
                                    }else{
                                        $result1 = Users::where('uid',$orderInfo[0]['uid'])->increment('coin',$coinAmount);
                                    }
                                    //留个接口，代理收款------------------------------------------------------------------------
                                    if($orderInfo[0]['daili_id'] != 0){
                                        $DailiDetail = Daili::where('daili_id',$orderInfo[0]['daili_id'])->lockForUpdate()->get()->toArray();
                                        $dailiMoney = $orderInfo[0]['order_money'] * round($DailiDetail[0]['commission_rate'],2);
                                        $result3 = Daili::where('daili_id',$orderInfo[0]['daili_id'])->increment('current_commision',$dailiMoney);
                                    }
                                    if($result and $result1)
                                    {
                                        DB::commit();
                                        $this->logs('Success');
                                        exit('Success');

                                    }else{
                                        DB::rollBack();
                                        $this->logs('Error6');
                                        exit('Fail');
                                    }

                                }catch (\Exception $e) {
                                    DB::rollBack();
                                    $this->logs('Error5');
                                    exit('Fail');
                                }

                            }else{
                                $this->logs('order already success');
                                exit('Fail');
                            }
                        }else{
                            $this->logs('money not correct');
                            exit('Fail');
                        }
                    }else{
                        $this->logs('deposit order not exist');
                        exit('IncorrectOrder');//订单不存在
                    }

                }else{
                    $this->logs('sign not correct');
                    exit('Fail');//Sign签名验证失败
                }

            }else{
                $this->logs('Error1');
                exit('Fail');
            }

        }else{
            $this->logs('Error2');
            exit('Fail');
        }

    }

    private function logs($datas){
        $nowTime = date('Y-m-d H:i:s',time());
        $filename=storage_path().'/logs/callback/'.date('Ymd',time()).'.txt';
        $handle=fopen($filename,"a+");
        $files=fwrite($handle,$nowTime."\n".print_r($datas,true)."\n".'-------------------------'."\n");
        fclose($handle);
    }
}
