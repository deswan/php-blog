<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Stephanie walk in street</title>
    <link rel="stylesheet" href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<div id="app">
  <my-header></my-header>
<main id="main">
  <type-banner type="{{$type}}" @search="searchText = $event" :tags_years="tags_years"></type-banner>
  <article-list type="{{$type}}" :search="searchText" :articles_1="articles"></article-list>
  <pagination type="{{$type}}" v-show="!searchText" :page_sum="page_sum"></pagination>
</main>
  <my-footer></my-footer>
</div>
<script>
    window.Laravel = <?php echo json_encode([
        'csrfToken' => csrf_token(),
    ]); ?>;
    window.mytype = "<?php echo $type; ?>";
</script>
<script src="/js/type.js"></script>
</body>
</html>
