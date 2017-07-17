<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class StatController extends Controller
{
    public function index($year = null,$month = null){
      $year || $year = getdate()['year']; //默认今年
      if(!$month){
        $result = DB::select('SELECT MONTH(time) as m,count(*) as count FROM `visit_flow` WHERE YEAR(time) = ? group by m order by m', [$year]);
        $result = array_column($result,'count','m');
        for($i=1;$i<=12;$i++){
          $data[] = isset($result[$i]) ? $result[$i] : 0 ;
        }
      }else{
        $result = DB::select('SELECT DAYOFMONTH(time) as d,count(*) as count FROM `visit_flow` WHERE YEAR(time) = ? and MONTH(time) = ? group by d order by d', [$year,$month]);
        $result = array_column($result,'count','d');
        $t = date('t',strtotime("$year-$month-1")); //当月总天数
        for($i=1;$i<=$t;$i++){
          $data[] = isset($result[$i]) ? $result[$i] : 0 ;
        }
      }
      $sum = array_sum($data);
      return response()->json(compact('data','sum','year','month'));
    }
}
