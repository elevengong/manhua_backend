<?php

namespace App\Http\Controllers\backend;

use App\Model\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\MyController;

class CategoryController extends MyController
{

    public function categorylist(Request $request){
        if($request->isMethod('post')){

        }else{

            $catetoryArray = Category::orderBy('priority', 'desc')->paginate($this->backendPageNum);
            return view('backend.categorylist', ['datas' => $catetoryArray])->with('admin', session('admin'));
        }
    }

    public function changestatus(Request $request){
        if($request->isMethod('post'))
        {
            $cid = request()->input('cid');
            $status = (request()->input('status') == 1) ? 0 : 1;
            $result = Category::where('cid', $cid)->update(['status' => $status]);
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

    public function addcategory(Request $request){
        if($request->isMethod('post'))
        {
            $input=$request->all();
            unset($input['_token']);
            $result = Category::create($input);
            if($result->cid)
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
            return view('backend.addcategory',compact('firstCategoryArray'));
        }
    }

    public function delete($cid)
    {

        $result = Category::destroy($cid);
        if ($result) {
            $data = array('status' => 1, 'msg' => "删除成功");
            return json_encode($data);
        } else {
            $data = array('status' => 0, 'msg' => "删除失败");
            return json_encode($data);
        }

    }

    public function editcategory(Request $request,$cid){
        if($request->isMethod('post'))
        {
            $input=$request->all();
            unset($input['_token']);
            $result = Category::where('cid',$cid)->update($input);
            if ($result) {
                $reData['status'] = 1;
                $reData['msg'] = "修改成功";
            } else {
                $reData['status'] = 0;
                $reData['msg'] = "修改失败";
            }
            echo json_encode($reData);
        }else{
            $categoryDate = Category::find($cid)->toArray();
            $firstCategoryArray = Category::where('parents_id','0')->orderBy('priority','desc')->get()->toArray();
            return view('backend.editcategory', compact('categoryDate','firstCategoryArray'));
        }
    }
}
