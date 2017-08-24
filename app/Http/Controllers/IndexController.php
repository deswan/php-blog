<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class IndexController extends Controller
{
    private $itemPerPage = 5;
    public function index(){
        return view('home.index');
    }
    public function code(){
      return view('home.type',['type'=>'code']);
    }
    public function essay(){
      return view('home.type',['type'=>'essay']);
    }
    public function article(\App\Article $article){
        $article->type = $article->categories()->value('type') ? 'essay' : 'code';
        $article->tags = $article->categories()->select('id','name','type')->get();

        //包含相同标签的文章
        $related = DB::table('article_category')
          ->select(DB::raw('articles.id, articles.title,
          YEAR(articles.created_at) as year,
          MONTH(articles.created_at) as month,
          DAYOFMONTH(articles.created_at) as day'))
          ->where('articles.id','!=',$article->id)
          ->whereIn('article_category.category_id',$article->tags->pluck('id'))
          ->join('articles','articles.id','=','article_category.article_id')
          ->groupBy('articles.id','articles.title','articles.created_at')  //去重
          ->latest('articles.created_at')
          ->take(4)->get();

        //同类别（code/essay）的文章
        if(!count($related)){
          $related = DB::table('categories')
            ->select(DB::raw('articles.id, articles.title,
            YEAR(articles.created_at) as year,
            MONTH(articles.created_at) as month,
            DAYOFMONTH(articles.created_at) as day'))
            ->where('articles.id','!=',$article->id)
            ->where('categories.type','=',$article->categories()->value('type'))
            ->join('article_category','categories.id','=','article_category.category_id')
            ->join('articles','articles.id','=','article_category.article_id')
            ->groupBy('articles.id','articles.title','articles.created_at')  //去重
            ->latest('articles.created_at')
            ->take(4)
            ->get();
        }

        $article->related = $related;

        //同类别文章中的上一篇（新一次发表）
        $last = DB::table('categories')
          ->select(DB::raw('articles.id, articles.title'))
          ->where('articles.created_at','>',$article->created_at)
          ->where('categories.type','=',$article->categories()->value('type'))
          ->join('article_category','categories.id','=','article_category.category_id')
          ->join('articles','articles.id','=','article_category.article_id')
          ->groupBy('articles.id','articles.title','articles.created_at')  //去重
          ->oldest('articles.created_at')
          ->take(1)->get();

          //同类别文章中的下一篇（旧一次发表）
        $next = DB::table('categories')
          ->select(DB::raw('articles.id, articles.title'))
          ->where('articles.created_at','<',$article->created_at)
          ->where('categories.type','=',$article->categories()->value('type'))
          ->join('article_category','categories.id','=','article_category.category_id')
          ->join('articles','articles.id','=','article_category.article_id')
          ->groupBy('articles.id','articles.title','articles.created_at')  //去重
          ->latest('articles.created_at')
          ->take(1)->get();

        count($last) && ($article->last = $last[0]);
        count($next) && ($article->next = $next[0]);


        return view('home.article',compact('article'));
    }
    public function getTagsAndYears(Request $r,$type = null){
      if($type === null){
        $tags = \App\Category::has('articles')->select('id','name','type')->orderBy('updated_at','desc')->get();
        $years = DB::select('select YEAR(created_at) as  year from articles group by year order by year desc');
      }else if($type === 'code'){
        $tags = \App\Category::has('articles')->select('id','name')->where('type',0)->latest('updated_at')->get();
        $years = DB::select('select YEAR(articles.created_at) as  year from articles,article_category,categories where articles.id = article_category.article_id and categories.id = article_category.category_id and categories.type=0 group by year order by year desc');
      }else if($type === 'essay'){
        $tags = \App\Category::has('articles')->select('id','name')->where('type',1)->latest('updated_at')->get();
        $years = DB::select('select YEAR(articles.created_at) as  year from articles,article_category,categories where articles.id = article_category.article_id and categories.id = article_category.category_id and categories.type=1 group by year order by year desc');
      }
      $years = array_column($years,'year');
      return compact('tags','years');
    }
    public function getArticles(Request $request,$type=null){
      $tagId = $request->input('tagId', 0);
      $year = intval($request->input('year', 0));
      $searchText = $request->input('search', '');
      $page = $request->input('page', 1);

      $query = DB::table('articles')
      ->select(DB::raw('articles.id,
      articles.title,
      articles.outline,
      YEAR(articles.created_at) as year,
      MONTH(articles.created_at) as month,
      DAYOFMONTH(articles.created_at) as day'))
      ->groupBy('articles.id','articles.title','articles.outline','articles.created_at');

      if($type){
        $type == 'code' ? ($typeCode = 0) : ($typeCode = 1) ;
        $query = $query
        ->join('article_category','articles.id','=','article_category.article_id')
        ->join('categories','categories.id','=','article_category.category_id')
        ->where('categories.type',$typeCode);
      }

      if($tagId){
        if(!$type){
          $query = $query->join('article_category','articles.id','=','article_category.article_id');
        }
        $query = $query->where('article_category.category_id',$tagId);
      }

      if($year){
        $query = $query
        ->where('year',$year);
      }

      if($searchText){
        $searchText = strtolower($searchText);
        $searchArr = preg_split('/\s+/',$searchText);
        if($schText = array_shift($searchArr)){
          $query = $query
          ->where('articles.title','like', "%$schText%")
          ->orWhere('articles.outline','like', "%$schText%");
          foreach($searchArr as $schText){
            $query = $query
            ->orwhere('articles.title','like', "%$schText%")
            ->orWhere('articles.outline','like', "%$schText%");
          }
        }
      }

      $articles = $query->latest('articles.created_at')->skip(($page-1)*$this->itemPerPage)->take($this->itemPerPage)->get();
      foreach($articles as &$article){
        $article->tags = \App\Article::find($article->id)->categories()->select('id','name','type')->get();
      }
      return $articles;
    }
    public function getPageSum(Request $request,$type=null){
      $tagId = $request->input('tagId', 0);
      $year = intval($request->input('year', 0));

      $query = DB::table('articles')->select('articles.id')->groupBy('articles.id');

      if($type){
        $type == 'code' ? ($typeCode = 0) : ($typeCode = 1) ;
        $query = $query
        ->join('article_category','articles.id','=','article_category.article_id')
        ->join('categories','categories.id','=','article_category.category_id')
        ->where('categories.type',$typeCode);
      }

      if($tagId){
        if(!$type){
          $query = $query->join('article_category','articles.id','=','article_category.article_id');
        }
        $query = $query->where('article_category.category_id',$tagId);
      }

      if($year){
        $query = $query
        ->where('year',$year);
      }

      $page = intval(count($query->get())/$this->itemPerPage)+1;
      return $page;
    }
    public function getTypeData(Request $request,$type=null){
      $data['articles'] = $this->getArticles($request,$type);
      $data['tags_years'] = $this->getTagsAndYears($request,$type);
      $data['page_sum'] = $this->getPageSum($request,$type);
      return response()->json($data);
    }
    public function getIndexData(Request $request){
      $data['articles'] = $this->getArticles($request);
      $data['page_sum'] = $this->getPageSum($request);
      return response()->json($data);
    }
}
