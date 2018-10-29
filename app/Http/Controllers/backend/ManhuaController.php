<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\MyController;
use App\Model\Category;
use App\Model\Manhua;
use App\Model\ManhuaChapter;
use App\Model\ManhuaPhotos;
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

    public function deal(Request $request){
        if($request->isMethod('post')){
            $manhua_id = request()->input('manhua_id');
            //判断该漫画ID是否已经存在manhuachapters表中
            $re = ManhuaChapter::where('manhua_id',$manhua_id)->get()->toArray();
            if(!empty($re))
            {
                $reData['status'] = 0;
                $reData['msg'] = "该漫画ID已经存在";
                echo json_encode($reData);
                exit;
            }


            $dir =  dirname(dirname(dirname(dirname(__DIR__))))."/public/readyupload/";
            $target_dir =  dirname(dirname(dirname(dirname(__DIR__))))."/public/manhua/";
            $datas = $this->my_scandir($dir);
            //print_r($datas);exit;
            $priority = 1;
            $chapterData = array();
            $count = count($datas[1]);
            foreach ($datas[1] as $file=> $data)
            {
//                print_r($data);
//                echo "<br>------------------<br>";

                $chapterData = array(
                    'manhua_id' => $manhua_id,
                    'chapter_name' => $priority,
                    'priority' => $priority,
                    'views' => rand(100,999)
                );
                $result = ManhuaChapter::create($chapterData);
                $chapter_id = $result->chapter_id;

                if($priority != 1){
                    $preData = ManhuaChapter::select('chapter_id')->where('manhua_id',$manhua_id)->where('priority',$priority-1)->get()->toArray();

                    //先更新当前chapter_id,再更新前一条chapter_id
                    ManhuaChapter::where('chapter_id',$chapter_id)->update(['pre_chapter_id'=> $preData[0]['chapter_id']]);
                    ManhuaChapter::where('chapter_id',$preData[0]['chapter_id'])->update(['next_chapter_id'=> $chapter_id]);
                }

                $rand = rand(1,100);
                foreach ($data as $num=>$photo)
                {
                    //入库之前，先把图片存到指定的文件夹里，改名，再获取图片最新的名字
                    echo $old_photo_path =  dirname(dirname(dirname(dirname(__DIR__))))."/public/readyupload/1/".$file.'/'.$photo;
                    echo "<br>";
                    $target_dir_1 =  dirname(dirname(dirname(dirname(__DIR__))))."/public/manhua/".$manhua_id."/";
                    $target_dir_2 = $target_dir_1.$chapter_id."/";
                    $new_photo_name = time().$manhua_id.$chapter_id.$rand.".jpg";
                    if(!is_dir($target_dir_1)){
                        mkdir($target_dir_1, 0777);
                    }
                    if(!is_dir($target_dir_2)){
                        mkdir($target_dir_2, 0777);
                    }


                    copy($old_photo_path,$target_dir_2.$new_photo_name);




                    $photoData = array(
                        'chapter_id' => $chapter_id,
                        'photo' => '/'.$manhua_id.'/'.$chapter_id.'/'.$new_photo_name,
                        'priority' => $num
                    );
                    ManhuaPhotos::create($photoData);
                    $rand ++;
                }

                $priority ++;
            }
            $reData['status'] = 1;
            $reData['msg'] = "添加成功";
            echo json_encode($reData);
            //print_r($datas);
        }else{
            return view('backend.manhuadeal');
        }




    }

    private function my_scandir($dir){
        if(is_dir($dir)){
            $files = array();
            $child_dirs = scandir($dir);
            foreach($child_dirs as $child_dir){
                //'.'和'..'是Linux系统中的当前目录和上一级目录，必须排除掉，
                //否则会进入死循环，报segmentation falt 错误
                if($child_dir != '.' && $child_dir != '..'){
                    if(is_dir($dir.'/'.$child_dir)){
                        $files[$child_dir] = $this->my_scandir($dir.'/'.$child_dir);
                    }else{
                        $files[] = $child_dir;
                    }
                }
            }
            return $files;
        }else{
            return $dir;
        }
    }


}
