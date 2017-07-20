<?php
use Illuminate\Support\Collection;
function sql_result_to_json(Collection $sql_result,...$grouped_cols){
  $c = $sql_result->groupBy('id');
  foreach($c as $k=>$v){
    $c[$k] = $v[0];
    foreach($grouped_cols as $col){
      $c[$k][$col] = array_column($v,$col);
    }
  }
  return $c;
}
