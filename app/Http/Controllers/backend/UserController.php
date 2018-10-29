<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\MyController;
use App\Model\Users;
use Illuminate\Http\Request;
use App\Http\Requests;
use Crypt;

class UserController extends MyController
{
    public function userlist(Request $request){
        if($request->isMethod('post')){
            $searchword = request()->input('searchword');
            $userArray = Users::where('user_name','like','%'.$searchword.'%')->orderBy('uid', 'desc')->paginate($this->backendPageNum);
        }else{
            $userArray = Users::orderBy('uid', 'desc')->paginate($this->backendPageNum);
        }
        return view('backend.userlist', ['datas' => $userArray])->with('admin', session('admin'));

    }

    public function changestatus(Request $request){
        if($request->isMethod('post'))
        {
            $uid = request()->input('uid');
            $status = (request()->input('status') == 1) ? 0 : 1;
            $result = Users::where('uid', $uid)->update(['status' => $status]);
            if ($result) {
                $data['status'] = 1;
                $data['msg'] = "修改成功";
            } else {
                $data['status'] = 0;
                $data['msg'] = "修改失败";
            }
            echo json_encode($data);
        }
    }

    public function chnagepwd(Request $request){
        if($request->isMethod('post')){
            $uid = request()->input('uid');
            $pwd = request()->input('pwd');
            $newPassword= Crypt::encrypt($pwd);
            $result = Users::where('uid', $uid)->update(['pwd' => $newPassword]);
            if ($result) {
                $data['status'] = 1;
                $data['msg'] = "修改成功";
            } else {
                $data['status'] = 0;
                $data['msg'] = "修改失败";
            }
            echo json_encode($data);
        }

    }

}
