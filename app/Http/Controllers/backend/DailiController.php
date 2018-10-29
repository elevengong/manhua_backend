<?php

namespace App\Http\Controllers\backend;

use App\Model\Daili;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\MyController;
use Crypt;

class DailiController extends MyController
{
    public function daililist(Request $request){
        if($request->isMethod('post')){
            $searchword = request()->input('searchword');
            $dailiArray = Daili::where('daili_name','like','%'.$searchword.'%')->orderBy('daili_id', 'desc')->paginate($this->backendPageNum);
        }else{
            $dailiArray = Daili::orderBy('daili_id', 'desc')->paginate($this->backendPageNum);
        }
        return view('backend.daililist', ['datas' => $dailiArray])->with('admin', session('admin'));
    }

    public function changestatus(Request $request){
        if($request->isMethod('post')){
            $daili_id = request()->input('daili_id');
            $status = (request()->input('status') == 1) ? 0 : 1;
            $result = Daili::where('daili_id', $daili_id)->update(['status' => $status]);
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
            $daili_id = request()->input('daili_id');
            $pwd = request()->input('pwd');
            $newPassword= Crypt::encrypt($pwd);
            $result = Daili::where('daili_id', $daili_id)->update(['pwd' => $newPassword]);
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

    public function adddaili(Request $request){
        if($request->isMethod('post')){
            $input=$request->all();
            unset($input['_token']);
            $password= Crypt::encrypt($input['pwd']);
            $input['pwd'] = $password;
            $result = Daili::create($input);
            if($result->daili_id)
            {
                $reData['status'] = 1;
                $reData['msg'] = "添加成功";
            }else{
                $reData['status'] = 0;
                $reData['msg'] = "添加失败";
            }
            echo json_encode($reData);
        }else{
            return view('backend.adddaili');
        }
    }




}
