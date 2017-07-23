<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>code -- Stephanie walk in street</title>
     <link href="http://apps.bdimg.com/libs/highlight.js/9.1.0/styles/tomorrow-night.min.css" rel="stylesheet">
     <link rel="stylesheet" href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body data-id="{{$article->id}}">
<div id="app">
    <my-header :disable-router="true"></my-header>
<section id="main">
  <article id="article" style="visibility:hidden">
    <header>
    <h1 class="article-h1">
      <span class="article-title">{{$article->title}}</span>
    </h1>
    <time class="article-time">{{$article->created_at}}</time>
  </header>
    <section class="article-body">{!! $article->body !!}</section>
    <footer class="article-footer">
      @foreach($article->tags as $tag)
      <a href="/{{$tag->type ? 'essay' : 'code'}}?tagId={{$tag->id}}" class="badge">{{$tag->name}}</a>
      @endforeach
    </footer>
  </article>
</section>
<my-footer></my-footer>
</div>
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
