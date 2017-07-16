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

    public function validateTitle(Request $r){
        Log::debug('App\Article::find($r->title)');
        $this->validate($r,['title'=>'required|unique:articles,title']);
        return response()->json([]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.write');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'title'=>'required|filled|max:20',
            'category'=>'required|filled|exists:categories,id',
            'short'=>'required|filled|max:50',
            'text'=>'required|filled',
            'draft'=>'required|boolean'
        ]);
        if(!$request->draft){   //发表
            $article = App\Article::create([
                'title'=>$request->title,
                'text'=>$request->text,
                'short'=>$request->short,
                'draft'=>$request->draft
            ]);
            foreach($request->category as $cid){
                $article->categories()->attach($cid);
            }
        }
        return back();
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
