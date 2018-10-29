<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\MyController;
use App\Model\Category;
use App\Model\Manhua;
use Illuminate\Http\Request;

use App\Http\Requests;

class ManhuaController extends MyController
{
    public function manhualist(Request $request){
        if($request->isMethod('post')){
            $searchword = request()->input('searchword');
            $manhuaArray = Manhua::where('name','like','%'.$searchword.'%')->orderBy('manhua_id', 'desc')->paginate($this->backendPageNum);
        }else{
            //$manhuaArray = Manhua::orderBy('manhua_id', 'desc')->paginate($this->backendPageNum);
            $manhuaArray = Manhua::select('manhua.*','category.c_name')
                ->leftJoin('category',function ($join){
                    $join->on('category.cid','=','manhua.cid');
                })->
            orderBy('manhua.manhua_id', 'desc')->paginate($this->backendPageNum);
        }
        return view('backend.manhualist', ['datas' => $manhuaArray])->with('admin', session('admin'));
    }



    public function addmanhua(Request $request){
        if($request->isMethod('post')){
            $input=$request->all();
            unset($input['_token']);
            $result = Manhua::create($input);
            if($result->manhua_id)
            {
                $reData['status'] = 1;
                $reData['msg'] = "添加成功";
            }else{
                $reData['status'] = 0;
                $reData['msg'] = "添加失败";
            }
            echo json_encode($reData);

        }else{
            $firstCategoryArray = Category::where('parents_id','0')->orderBy('priority','desc')->get()->toArray();
            return view('backend.addmanhua',compact('firstCategoryArray'));
        }
    }


}
