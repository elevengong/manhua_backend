<?php

namespace App\Http\Controllers\backend;

use App\Model\Statistics;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\MyController;

class StatisticsController extends MyController
{
    public function statisticslist(Request $request){
        if($request->isMethod('post')){
            $searchword = request()->input('searchword');
            $statistics = Statistics::select('statistics.*','daili.daili_name')
                ->leftJoin('daili',function ($join){
                    $join->on('daili.daili_id','=','statistics.daili_id');
                })->where('statistics.daili_id',$searchword)
                ->orderBy('statistics.created_at', 'desc')->paginate(100);

        }else{
            $statistics = Statistics::select('statistics.*','daili.daili_name')
                ->leftJoin('daili',function ($join){
                    $join->on('daili.daili_id','=','statistics.daili_id');
                })
                ->orderBy('statistics.created_at', 'desc')->paginate(100);
        }
        return view('backend.statisticslist',compact('statistics'))->with('admin', session('admin'));;

    }
}
