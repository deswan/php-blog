<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{$article->title}} - Stephanie walk in street</title>
     <link href="http://apps.bdimg.com/libs/highlight.js/9.1.0/styles/tomorrow-night.min.css" rel="stylesheet">
     <link rel="stylesheet" href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body data-id="{{$article->id}}" data-type="{{$article->type}}">
<div id="app">
<my-header :disable-router="true"></my-header>
<section id="main">
  <article id="article" style="visibility:hidden">

    <div class="article-tags">
      <img class="article-type-logo">
      @foreach($article->tags as $tag)
      <a href="/{{$tag->type ? 'essay' : 'code'}}?tagId={{$tag->id}}" class="badge {{$tag->type ? 'essay' : 'code'}}">{{$tag->name}}</a>
      @endforeach
    </div>

    <header>
      <h1 class="article-h1">
        <span class="article-title">{{$article->title}}</span>
      </h1>
      <time class="article-time">{{$article->created_at}}</time>
    </header>

    <section class="article-body">{!! $article->body !!}</section>

    <footer class="article-footer">
      <section class="related">
        <h1 class="related-header">相关文章</h1>
        <ul class="related-ul">
          @foreach($article->related as $related)
          <li class="related-li">
            <a href="/article/{{$related->id}}" class="related-li-title">《{{$related->title}}》</a>
          </li>
          @endforeach
        </ul>
      </section>
    </footer>

    <div id="disqus_thread"></div>

  </article>

  <section id="shift-article" style="visibility:hidden">
    @if(isset($article->last))
    <a class="shift-article-item last" href="/article/{{$article->last->id}}">
      <i class="fa fa-chevron-left shift-logo" aria-hidden="true"></i>
      <span class="shift-title">{{$article->last->title}}</span>
    </a>
    @endif
    @if(isset($article->next))
    <a class="shift-article-item next" href="/article/{{$article->next->id}}">
      <span class="shift-title">{{$article->next->title}}</span>
      <i class="fa fa-chevron-right shift-logo" aria-hidden="true"></i>
    </a>
    @endif
  </section>

</section>
<my-footer></my-footer>
</div>
<script>

/**
*  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
*  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/
/*
var disqus_config = function () {
this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
};
*/
(function() { // DON'T EDIT BELOW THIS LINE
var d = document, s = d.createElement('script');
s.src = 'https://wangxingzi.disqus.com/embed.js';
s.setAttribute('data-timestamp', +new Date());
(d.head || d.body).appendChild(s);
})();
</script>
<script>
    window.Laravel = <?php echo json_encode([
        'csrfToken' => csrf_token(),
    ]);
    ?>;
</script>
<script src="/js/article.js"></script>
<script src="http://apps.bdimg.com/libs/highlight.js/9.1.0/highlight.min.js"></script>
<script>hljs.initHighlightingOnLoad();</script>
</body>
</html>
