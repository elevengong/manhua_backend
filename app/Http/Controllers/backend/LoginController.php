<?php

namespace App\Http\Controllers\backend;

use App\Model\Admin;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\MyController;
//use Illuminate\Support\Facades\Crypt;
use Crypt;

require_once 'resources/org/code/ValidateCode.php';
class LoginController extends MyController
{
    public function login(Request $request){
        if($request->isMethod('post'))
        {
            if($this->Ipbaimingdan == 1)
            {
                $loginIp = $request->getClientIp();
//                $loginIp = '125.252.99.36';
                $ipInfo = $this->getIpInfoByCurl($loginIp);
//                print_r($ipInfo);
                if($ipInfo['data']['country_id'] != 'PH')
                {
                    $data['status'] = 0;
                    $data['msg'] = '你的ip没有通过白名单';
                    echo json_encode($data);
                    exit;
                }

            }

            $name = request()->input('name');
            $pwd = request()->input('pwd');
            $code = request()->input('code');

            //验证验证码
            if(strtolower($code) == session('code'))
            {
                $result = Admin::where('name',$name)->get()->toArray();
                if($result)
                {
                    if($result[0]['status']==1)
                    {
                        $stored_pwd= Crypt::decrypt($result[0]['pwd']);
                        if($stored_pwd == $pwd)
                        {
                            session(['admin' => $name, 'admin_id' => $result['0']['admin_id']]);

                            //更新该管理员的login ip和最近login时间
                            //$updata_at = date('Y');

                            $ip = $request->getClientIp();
                            $lastlogined = date('Y-m-d h:i:s',time());
                            $result = Admin::where('admin_id',session('admin_id'))->update(['login_ip'=>$ip, 'lastlogined_at'=>$lastlogined]);

                            $data['status'] = 1;
                            $data['msg'] = '登陆成功，请等待跳转';
                        }else{
                            $data['status'] = 0;
                            $data['msg'] = '帐号或密码错误';
                        }
                    }else{
                        $data['status'] = 0;
                        $data['msg'] = '此用户已禁用';
                    }

                }else{
                    $data['status'] = 0;
                    $data['msg'] = '此用户不存在';
                }
            }else{
                $data['status'] = 0;
                $data['msg'] = '验证码输入不正确';
            }
            echo json_encode($data);

        }else{
            return view('backend.login');
        }

    }

    //缩略图
    public function code(){
        $code = new \ValidateCode();
        $code->doimg();
        session(['code' => $code->getCode()]);
    }




}
