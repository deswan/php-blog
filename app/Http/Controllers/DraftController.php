<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use Illuminate\Support\Facades\DB;
class DraftController extends Controller
{
    public function index()
    {
        $draft = App\Draft::select('id','updated_at','title')->orderBy('updated_at','desc')->get();
        return response()->json($draft);
    }

    //新建（草稿/发表）
    public function store(Request $request)
    {
        $this->validate($request,[
            'title'=>'max:50',
            'outline'=>'max:100'
        ]);
        $draft = App\Draft::create([
          'title'=>$request->input('title'),
          'body'=>$request->input('body'),
          'outline'=>$request->input('outline'),
        ]);
        return response()->json(['id'=>$draft->id]);
    }

    //发布
    public function release(Request $request,App\Draft $draft)
    {
        $this->validate($request,[
            'title'=>'required|filled|max:50',
            'coding_tags'=>'filled|array',
            'essay_tags'=>'filled|array',
            'outline'=>'required|filled|max:100',
            'body'=>'required|filled'
        ]);
        DB::transaction(function () use ($request,$draft){
          $draft->delete();
          $article = new App\Article;
          $article->title = $request->input('title');
          $article->outline = $request->input('outline');
          $article->body = $request->input('body');
          $article->save();
          if($request->input('coding_tags')){
            $tags = $request->input('coding_tags');
          }else{
            $tags = $request->input('essay_tags');
          }
          foreach($tags as $tag_id){
            $article->categories()->attach($tag_id);
          }
        });
        return response()->json('');
    }

    public function show($id)
    {
        //
    }

    public function edit(App\Draft $draft)
    {
      return response()->json($draft);
    }

    //更新（草稿/发表）
    public function update(Request $request,App\Draft $draft)
    {
      $this->validate($request,[
          'title'=>'max:50',
          'outline'=>'max:100'
      ]);
      $draft->title = $request->input('title');
      $draft->outline = $request->input('outline');
      $draft->body = $request->input('body');
      $draft->save();
      return response()->json(['id'=>$draft->id]);
    }

    public function destroy(App\Draft $draft)
    {
        $draft->delete();
        return response()->json('');
    }
}
