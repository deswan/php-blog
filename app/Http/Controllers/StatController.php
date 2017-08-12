<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class StatController extends Controller
{
    public function getData(Request $request,$article_id=null){
      $nowYear = getdate()['year'];
      $year = intval($request->input('year',$nowYear));
      $month = intval($request->input('month'));
      $query = DB::table('visits')->groupBy('time1')->orderBy('time1');

      if($article_id){
        $query = $query->where('article_id','=',$article_id);
      }

      if(!$month){    // exp. 2017
        $query = $query->select(DB::raw('MONTH(time) as time1,count(*) as count'))
          ->whereRaw('YEAR(time) = '.$year);
        $result = $query->get()->toArray();
        foreach($result as $k=>$v){
          $result[$k] = (array)$v;
        }
        $result = array_column($result,'count','time1');
        for($i=1;$i<=12;$i++){
          $data[] = isset($result[$i]) ? $result[$i] : 0 ;
        }
      }else{  // exp. 2017/1
        $query = $query->select(DB::raw('DAYOFMONTH(time) as time$1,count(*) as count'))
          ->whereRaw('YEAR(time) = '.$year)
          ->whereRaw('MONTH(time) = '.$month);
        $result = $query->get()->toArray();
        foreach($result as $k=>$v){
          $result[$k] = (array)$v;
        }
        $result = array_column($result,'count','time$1');
        $t = date('t',strtotime("$year-$month-1")); //当月总天数
        for($i=1;$i<=$t;$i++){
          $data[] = isset($result[$i]) ? $result[$i] : 0 ;
        }
      }
      $sum = array_sum($data);
      return response()->json(compact('data','sum','year','month','nowYear'));
    }
    public function visit(Request $request){
      $article_id = $request->input('article_id',null);
      \App\Visit::create(['time'=>date('Y-m-d H:i:s'),'article_id'=>$article_id]);
      return response()->json(['error'=>0]);
    }
}
