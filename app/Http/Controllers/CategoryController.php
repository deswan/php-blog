<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
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
            'name' => 'required|unique:categories',
        ]);
        return response()->json([]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $r)
    {
//        switch ($r->type){
//            case 'coding':$type_id=0;break;
//            case 'essay':$type_id=1;break;
//            default:return redirect('/admin/categories');
//        }
        Log::error($r->all());
        $this->validate($r, [
            'name' => 'required|unique:categories|max:20',
            'type' => 'required|in:1,2',
        ]);
        App\Category::create(['name'=>$r->name,'type'=>$r->type]);
        return redirect('admin/categories');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $cat = App\Category::find($id);
        $cat->name = $request->name;
        $cat->save();
        return redirect('admin/categories');
    }

    public function delete($id)
    {
        App\Category::find($id)->delete();
        return redirect('admin/categories');
    }
}
