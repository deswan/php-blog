<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use Log;
class DraftController extends Controller
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
