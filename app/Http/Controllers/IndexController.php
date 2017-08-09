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
    public function article(\App\Article $article){
        $article['type'] = $article->categories()->first()['type'] ? 'essay' : 'code';
        $article['tags'] = $article->categories()->select('id','name','type')->get();

        $related = DB::table('article_category')
          ->select(DB::raw('articles.id, articles.title,
          YEAR(articles.created_at) as year,
          MONTH(articles.created_at) as month,
          DAYOFMONTH(articles.created_at) as day'))
          ->where('articles.id','!=',$article->id)
          ->where('article_category.article_id','=',$article->id)
          ->join('articles','articles.id','=','article_category.article_id')
          ->groupBy('articles.id','articles.title','articles.created_at')  //去重
          ->latest('articles.created_at')
          ->take(4)
          ->get();

        if(!count($related)){
          $related = DB::table('categories')
            ->select(DB::raw('articles.id, articles.title,
            YEAR(articles.created_at) as year,
            MONTH(articles.created_at) as month,
            DAYOFMONTH(articles.created_at) as day'))
            ->where('articles.id','!=',$article->id)
            ->where('categories.type','=',$article->categories[0]['type'])
            ->join('article_category','categories.id','=','article_category.category_id')
            ->join('articles','articles.id','=','article_category.article_id')
            ->groupBy('articles.id','articles.title','articles.created_at')  //去重
            ->latest('articles.created_at')
            ->take(4)
            ->get();
        }

        $last = DB::table('categories')
          ->select(DB::raw('articles.id, articles.title'))
          ->where('articles.created_at','>',$article->created_at)
          ->where('categories.type','=',$article->categories[0]['type'])
          ->join('article_category','categories.id','=','article_category.category_id')
          ->join('articles','articles.id','=','article_category.article_id')
          ->groupBy('articles.id','articles.title','articles.created_at')  //去重
          ->orderBy('articles.created_at')
          ->take(1)
          ->get();

        $next = DB::table('categories')
          ->select(DB::raw('articles.id, articles.title'))
          ->where('articles.created_at','<',$article->created_at)
          ->where('categories.type','=',$article->categories[0]['type'])
          ->join('article_category','categories.id','=','article_category.category_id')
          ->join('articles','articles.id','=','article_category.article_id')
          ->groupBy('articles.id','articles.title','articles.created_at')  //去重
          ->orderBy('articles.created_at','desc')
          ->take(1)
          ->get();

        count($last) && ($article['last'] = $last[0]);
        count($next) && ($article['next'] = $next[0]);
        $article['related'] = $related;

        return view('home.article',compact('article'));
    }
    public function getTagsAndYears($type = null){
      if($type === null){
        $tags = \App\Category::has('articles')->select('id','name','type')->orderBy('updated_at','desc')->get();
        $years = DB::select('select YEAR(created_at) as  year from articles group by year order by year desc');
      }else if($type === 'code'){
        $tags = \App\Category::has('articles')->select('id','name')->where('type',0)->orderBy('updated_at','desc')->get();
        $years = DB::select('select YEAR(articles.created_at) as  year from articles,article_category,categories where articles.id = article_category.article_id and categories.id = article_category.category_id and categories.type=0 group by year order by year desc');
      }else if($type === 'essay'){
        $tags = \App\Category::has('articles')->select('id','name')->where('type',1)->orderBy('updated_at','desc')->get();
        $years = DB::select('select YEAR(articles.created_at) as  year from articles,article_category,categories where articles.id = article_category.article_id and categories.id = article_category.category_id and categories.type=1 group by year order by year desc');
      }
      $years = array_column($years,'year');
      return response()->json(compact('tags','years'));
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
      DAYOFMONTH(articles.created_at) as day'));

      if($type||$tagId){
        $query = $query
        ->join('article_category','articles.id','=','article_category.article_id')
        ->join('categories','categories.id','=','article_category.category_id');
      }

      if($type){
        $type == 'code' ? ($type = 0) : ($type = 1) ;
        $query = $query
        ->where('categories.type','=',$type)
        ->groupBy('articles.id','articles.title','articles.outline','articles.created_at');
      }

      if($tagId){
        $query = $query
        ->where('categories.id','=',$tagId);
      }

      if($year){
        $query = $query
        ->whereRaw('YEAR(`articles`.`created_at`) = '.$year );
      }

      if($searchText){
        $searchText = strtolower($searchText);
        $searchArr = preg_split('/\s+/',$searchText);
        if($schText = array_shift($searchArr)){
          $query = $query
          ->where('articles.title','like', "%$schText%")
          ->orWhere('articles.outline','like', "%$schText%");
        }
        foreach($searchArr as $schText){
          $query = $query
          ->orwhere('articles.title','like', "%$schText%")
          ->orWhere('articles.outline','like', "%$schText%");
        }
      }

      $articles = $query->latest('articles.created_at')->skip(($page-1)*$this->itemPerPage)->take($this->itemPerPage)->get();
      foreach($articles as &$article){
        $a = \App\Article::find($article->id);
        $article->tags = $a->categories()->select('id','name','type')->get();
      }
      return response()->json($articles);
    }
    public function getPageSum(Request $request,$type=null){
      $tagId = $request->input('tagId', 0);
      $year = intval($request->input('year', 0));

      $query = DB::table('articles');

      if($type||$tagId){
        $query = $query
        ->join('article_category','articles.id','=','article_category.article_id')
        ->join('categories','categories.id','=','article_category.category_id');
      }

      if($type){
        $type == 'code' ? ($type = 0) : ($type = 1) ;
        $query = $query
        ->where('categories.type','=',$type)
        ->groupBy('articles.id','articles.title','articles.outline','articles.created_at');
      }

      if($tagId){
        $query = $query
        ->where('categories.id','=',$tagId);
      }

      if($year){
        $query = $query
        ->whereRaw('YEAR(`articles`.`created_at`) = '.$year );
      }

      $page = intval(count($query->pluck('articles.id'))/$this->itemPerPage)+1;
      return response()->json($page);
    }
}
