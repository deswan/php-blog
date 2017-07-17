<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use Log;
class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = App\Article::orderBy('created_at')->get();
        return view('admin.article_manage',compact('articles'));
    }

    //新建
    public function store(Request $request)
    {
        $this->validate($request,[
            'title'=>'required|filled|max:50',
            'coding_tags'=>'filled|array',
            'essay_tags'=>'filled|array',
            'outline'=>'required|filled|max:100',
            'body'=>'required|filled'
        ]);
        $article = null;
        DB::transaction(function () {
          $article = new App\Article;
          $article->title = $request->input('title');
          $article->outline = $request->input('outline');
          $article->body = $request->input('body');

          if($request->input('coding_tags')){
            $tags = $request->input('coding_tags')
            $article->type = 0;
          }else{
            $tags = $request->input('essay_tags')
            $article->type = 1;
          }
          foreach($tags as $tag_id){
            $article->categories()->attach($tag_id);
          }
        });
        return response()->json('');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    //更新
    public function update(Request $request, $id)
    {
      $this->validate($request,[
          'title'=>'required|filled|max:50',
          'coding_tags'=>'filled|array',
          'essay_tags'=>'filled|array',
          'outline'=>'required|filled|max:100',
          'body'=>'required|filled'
      ]);
      $article = null;
      DB::transaction(function () {
        $article = App\Article::find($id);
        $article->title = $request->input('title');
        $article->outline = $request->input('outline');
        $article->body = $request->input('body');

        if($request->input('coding_tags')){
          $tags = $request->input('coding_tags')
          $article->type = 0;
        }else{
          $tags = $request->input('essay_tags')
          $article->type = 1;
        }
        foreach($tags as $tag_id){
          $article->categories()->attach($tag_id);
        }
      });
      return response()->json('');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
