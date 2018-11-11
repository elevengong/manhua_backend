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
            $manhuaArray = Manhua::select('manhua.*','category.c_name')
                ->leftJoin('category',function ($join){
                    $join->on('category.cid','=','manhua.cid');
                })->where('manhua.name','like','%'.$searchword.'%')
                ->orderBy('manhua.manhua_id', 'desc')->paginate($this->backendPageNum);
        }else{
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

    public function editmanhua(Request $request, $manhua_id){
        if($request->isMethod('post')){
            $input=$request->all();
            unset($input['_token']);
            $result = Manhua::where('manhua_id',$manhua_id)->update($input);
            if ($result) {
                $reData['status'] = 1;
                $reData['msg'] = "修改成功";
            } else {
                $reData['status'] = 0;
                $reData['msg'] = "修改失败";
            }
            echo json_encode($reData);

        }else{
            $firstCategoryArray = Category::where('parents_id','0')->orderBy('priority','desc')->get()->toArray();
            $manhua = Manhua::find($manhua_id)->toArray();
            return view('backend.editmanhua',compact('manhua','firstCategoryArray'));
        }

    }

    public function chapterlist(Request $request,$manhua_id){
        if($request->isMethod('post')){
            $searchword = request()->input('searchword');
            $ManhuaChapterArray = ManhuaChapter::select('manhuachapters.*','manhua.name')
                ->leftJoin('manhua',function ($join){
                    $join->on('manhua.manhua_id','=','manhuachapters.manhua_id');
                })->where('manhuachapters.manhua_id',$searchword)
                ->orderBy('manhuachapters.priority', 'asc')->paginate(100);
        }else{
            if($manhua_id == 0)
            {
                $ManhuaChapterArray = ManhuaChapter::select('manhuachapters.*','manhua.name')
                    ->leftJoin('manhua',function ($join){
                        $join->on('manhua.manhua_id','=','manhuachapters.manhua_id');
                    })
                    ->orderBy('manhuachapters.priority', 'asc')->paginate(100);
            }else{
                $ManhuaChapterArray = ManhuaChapter::select('manhuachapters.*','manhua.name')
                    ->leftJoin('manhua',function ($join){
                        $join->on('manhua.manhua_id','=','manhuachapters.manhua_id');
                    })->where('manhuachapters.manhua_id',$manhua_id)
                    ->orderBy('manhuachapters.priority', 'asc')->paginate(100);
            }
        }
        return view('backend.chapterlist', ['datas' => $ManhuaChapterArray])->with('admin', session('admin'));

    }

    public function addchapter(Request $request){
        if($request->isMethod('post')){
            //先查询是该漫画ID是否存在
            $manhua_id = request()->input('manhua_id');
            $manhua = Manhua::find($manhua_id);
            if(empty($manhua)){
                $reData['status'] = 0;
                $reData['msg'] = "该漫画ID不存在";
                echo json_encode($reData);
                exit;
            }else{
                if($manhua->finish == 1){
                    $reData['status'] = 0;
                    $reData['msg'] = "该漫画系列已完结，不能再添加章节了";
                    echo json_encode($reData);
                    exit;
                }else{
                    $chapter_name = request()->input('chapter_name');
                    $chapter_cover = request()->input('chapter_cover');
                    $status = request()->input('status');
                    $vip = request()->input('vip');
                    $views = request()->input('views');
                    $coin = request()->input('coin');

                    //获取该漫画ID的最新章节
                    $lastChapter = ManhuaChapter::where('manhua_id',$manhua_id)->orderBy('priority','desc')->get()->take(1)->toArray();
                    if(empty($lastChapter))
                    {
                        //空表示没有章节，这次添加的就是第一章节
                        $inputData = array(
                            'manhua_id' => $manhua_id,
                            'chapter_name' => $chapter_name,
                            'chapter_cover' => $chapter_cover,
                            'status' => $status,
                            'vip' => $vip,
                            'pre_chapter_id' => 0,
                            'next_chapter_id' => 0,
                            'views' => $views,
                            'priority' => 0,
                            'coin' => $coin
                        );
                        $re1 = ManhuaChapter::create($inputData);
                        if($re1){
                            $reData['status'] = 1;
                            $reData['msg'] = "添加漫画章节成功，请再添加该章节的图片";
                        }else{
                            $reData['status'] = 0;
                            $reData['msg'] = "添加漫画章节失败";
                        }
                        echo json_encode($reData);

                    }else{
                        $lastChapterId = $lastChapter[0]['chapter_id'];
                        $lastChapterPriority = $lastChapter[0]['priority'];
                        $nowChapterPriority = $lastChapterPriority + 1;

                        $inputData = array(
                            'manhua_id' => $manhua_id,
                            'chapter_name' => $chapter_name,
                            'chapter_cover' => $chapter_cover,
                            'status' => $status,
                            'vip' => $vip,
                            'pre_chapter_id' => $lastChapterId,
                            'next_chapter_id' => 0,
                            'views' => $views,
                            'priority' => $nowChapterPriority,
                            'coin' => $coin
                        );
                        $re1 = ManhuaChapter::create($inputData);
                        //入库成功后获取章节ID更新到这部漫画的上一章节的下一页里
                        $re2 = ManhuaChapter::where('chapter_id',$lastChapterId)->update(['next_chapter_id' => $re1->chapter_id]);

                        if($re2){
                            $reData['status'] = 1;
                            $reData['msg'] = "添加漫画章节成功，请再添加该章节的图片";
                        }else{
                            $reData['status'] = 0;
                            $reData['msg'] = "添加漫画章节失败";
                        }
                        echo json_encode($reData);
                    }

                }
            }

        }else{
            return view('backend.addchapter');
        }
    }

    public function viewchapterphotos(Request $request, $chapter_id){
        $chpaterPhotos = ManhuaPhotos::where('chapter_id',$chapter_id)->where('status',1)->orderBy('priority','asc')->get()->toArray();
        return view('backend.viewchapterphotos',compact('chpaterPhotos'));
    }

    public function savechapterphotos(Request $request, $chapter_id){
        if($request->isMethod('post')){
            //先检查一下该章节下面有没有图片
            $photoCount = ManhuaPhotos::where('chapter_id',$chapter_id)->count();
            if($photoCount == 0)
            {
                $manhua_id = request()->input('manhua_id');
                //检查/public/chapter_temporary/目录下有没有图片
                $dir =  dirname(dirname(dirname(dirname(__DIR__))))."/public/chapter_temporary/";
                $photoArray = $this->my_scandir($dir);
                $target_dir_1 =  dirname(dirname(dirname(dirname(__DIR__))))."/public/manhua/".$manhua_id."/";
                $target_dir_2 = $target_dir_1.$chapter_id."/";
                if(!is_dir($target_dir_1)){
                    mkdir($target_dir_1, 0777);
                }
                if(!is_dir($target_dir_2)){
                    mkdir($target_dir_2, 0777);
                }

                foreach ($photoArray as $num=>$photo)
                {
                    $rand = rand(100,999);
                    $old_photo_path = $dir.$photo;
                    $new_photo_name = time().$this->random_string().$rand.".jpg";
                    copy($old_photo_path,$target_dir_2.$new_photo_name);

                    $photoData = array(
                        'chapter_id' => $chapter_id,
                        'photo' => '/'.$manhua_id.'/'.$chapter_id.'/'.$new_photo_name,
                        'priority' => $num
                    );
                    ManhuaPhotos::create($photoData);

                    //删除图片
                    unlink($old_photo_path);

                    $rand ++;
                }

                $reData['status'] = 1;
                $reData['msg'] = "添加图片成功";
                echo json_encode($reData);
                exit;


            }else{
                $reData['status'] = 0;
                $reData['msg'] = "该漫画章节ID下已经有图片存在了";
                echo json_encode($reData);
                exit;
            }


        }else{
            $info = ManhuaChapter::select('manhuachapters.*','manhua.name')->where('chapter_id',$chapter_id)
                ->leftJoin('manhua',function ($join){
                    $join->on('manhua.manhua_id','=','manhuachapters.manhua_id');
                })->get()->toArray();
            if(!empty($info)){
                return view('backend.savechapterphotos')->with('chapter_id',$chapter_id)->with('info',$info[0]);
            }else{
                echo "Error";exit;
            }

        }
    }

    public function editchapter(Request $request, $chapter_id){
        if($request->isMethod('post')){
            $input=$request->all();
            unset($input['_token']);
            $result = ManhuaChapter::where('chapter_id',$chapter_id)->update($input);
            if ($result) {
                $reData['status'] = 1;
                $reData['msg'] = "修改成功";
            } else {
                $reData['status'] = 0;
                $reData['msg'] = "修改失败";
            }
            echo json_encode($reData);

        }else{
            $ManhuaChapterDetail = ManhuaChapter::select('manhuachapters.*','manhua.name')
                ->leftJoin('manhua',function ($join){
                    $join->on('manhua.manhua_id','=','manhuachapters.manhua_id');
                })->where('manhuachapters.chapter_id',$chapter_id)->get()->toArray();
            return view('backend.editchapter')->with('data',$ManhuaChapterDetail[0]);
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

                foreach ($data as $num=>$photo)
                {
                    $rand = rand(100,999);
                    //入库之前，先把图片存到指定的文件夹里，改名，再获取图片最新的名字
                    echo $old_photo_path =  dirname(dirname(dirname(dirname(__DIR__))))."/public/readyupload/1/".$file.'/'.$photo;
                    echo "<br>";
                    $target_dir_1 =  dirname(dirname(dirname(dirname(__DIR__))))."/public/manhua/".$manhua_id."/";
                    $target_dir_2 = $target_dir_1.$chapter_id."/";
                    $new_photo_name = time().$this->random_string.$rand.".jpg";
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
