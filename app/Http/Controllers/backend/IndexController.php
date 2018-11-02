<?php

namespace App\Http\Controllers\backend;

use App\Model\Admin;
use App\Model\Attribute;
use Illuminate\Http\Request;
use App\Http\Controllers\MyController;
use App\Http\Requests;
use Crypt;


class IndexController extends MyController
{
    public function index(Request $request){

        return view('backend.layout.main')->with('admin',session('admin'));
    }

    //注销用户
    public function logout(Request $request){
        $this->deleteAllSession($request);
        $data['status'] = 1;
        $data['msg'] = "注销成功";
        echo json_encode($data);
    }

    //改当前管理员密码
    public function changepwd(Request $request){
        if($request->isMethod('post')){
            $newpwd = request()->input('newpwd');
            $newPassword= Crypt::encrypt($newpwd);

            $result = Admin::where('admin_id',session('admin_id'))->update(['pwd'=>$newPassword]);

            if($result)
            {
                $data['status'] = 1;
                $data['msg'] = "修改成功";
            }else{
                $data['status'] = 0;
                $data['msg'] = "修改失败";
            }
            echo json_encode($data);
        }
    }

    public function attributelist(Request $request){
        $datas = Attribute::orderBy('id','asc')->get()->toArray();
        return view('backend.setattribute',compact('datas'));
    }

    public function addstatic(Request $request){
        if($request->isMethod('post')){
            $input=$request->all();
            unset($input['_token']);
            $result = Attribute::create($input);
            if($result->id)
            {
                $reData['status'] = 1;
                $reData['msg'] = "添加成功";
            }else{
                $reData['status'] = 0;
                $reData['msg'] = "添加失败";
            }
            echo json_encode($reData);

        }else{
            return view('backend.addstatic');
        }

    }

    public function editstatic(Request $request,$id){
        if($request->isMethod('post')){
            $name = request()->input('name');
            $value = request()->input('value');
            $result = Attribute::where('id',$id)->update(['name'=> $name, 'value'=> $value]);
            if($result)
            {
                $reData['status'] = 1;
                $reData['msg'] = "修改成功";
            }else{
                $reData['status'] = 0;
                $reData['msg'] = "修改失败";
            }
            echo json_encode($reData);
        }else{
            $data = Attribute::find($id)->toArray();
            return view('backend.editstatic',compact('data'));
        }
    }

}
