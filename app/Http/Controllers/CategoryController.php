<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use App;
class CategoryController extends Controller
{
    public function index(){
        $result = \App\Category::orderBy('created_at')->get();
        foreach($result as $val){
          if($val['type']===0){
            $coding[]=$val;
          }else if($val['type']===1){
            $essay[]=$val;
          }
          unset($val['created_at']);
          unset($val['updated_at']);
          unset($val['type']);
        }
        return response()->json(compact('coding','essay'));
    }

    public function validateName(Request $r){
        $this->validate($r,[
            'name' => 'required|unique:categories,name',
        ]);
        return response()->json([]);
    }

    public function store(Request $r)
    {
        $this->validate($r, [
            'name' => 'required|unique:categories|max:20',
            'type' => 'required|in:0,1',
        ]);
        $m = App\Category::create(['name'=>$r->name,'type'=>$r->type]);
        return response()->json($m);

    }

    public function update(Request $request, App\Category $tag)
    {
        $this->validate($request, [
            'name' => 'required|max:20'
        ]);
        $tag->name = $request->name;
        $tag->save();
        return response()->json($tag);
    }

    public function destroy(App\Category $tag)
    {
        $tag->delete();
        return response()->json('');
    }
    public function show(App\Category $tag)
    {
        $tag;
        $articles = $tag->articles()->orderBy('updated_at','desc')->get();
        return response()->json(compact('tag','articles'));
    }
}
