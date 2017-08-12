<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use App;
class CategoryController extends Controller
{
    //列表
    public function index(){
        $result = \App\Category::latest('updated_at')->get();
        foreach($result as $val){
          if($val['type']===0){
            $coding[]=$val;
          }else if($val['type']===1){
            $essay[]=$val;
          }
        }
        return compact('coding','essay');
    }

    //检查名称是否重复
    public function validateName(Request $r){
        $this->validate($r,[
            'name' => 'required|unique:categories,name',
        ]);
        return '';
    }

    //新建
    public function store(Request $r)
    {
        $this->validate($r, [
            'name' => 'required|unique:categories|max:20',
            'type' => 'required|in:0,1',
        ]);
        return App\Category::create($r->all());

    }

    //更新
    public function update(Request $request, App\Category $tag)
    {
        $this->validate($request, [
            'name' => 'required|max:20'
        ]);
        $tag->name = $request->name;
        $tag->save();
        return $tag;
    }

    //删除
    public function destroy(App\Category $tag)
    {
        $tag->delete();
        $tag->articles()->detach();
        return '';
    }

    //显示详情
    public function show(App\Category $tag)
    {
        $articles = $tag->articles()->orderBy('updated_at','desc')->get();
        return compact('tag','articles');
    }
}
