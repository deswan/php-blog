<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="UTF-8">
  <title>Stephanie`s blog administration system</title>
  <link rel="stylesheet" href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
  <div id="app">
    <aside id="aside">
      <section class="center-block" id="aside-logo">
        <img :src="logo_src" class="img-responsive">
      </section>
      <ul class="nav nav-stacked aside-nav">
        <li><router-link to="/"><i class="fa fa-bar-chart"></i><br>流量</router-link></li>
        <li><router-link to="/write"><i class="fa fa-edit"></i><br>撰写</router-link></li>
        <li><router-link to="/articles"><i class="fa fa-archive"></i><br>文章</router-link></li>
        <li><router-link to="/tags"><i class="fa fa-tags"></i><br>TAG</router-link></li>
        <li><router-link to="/drafts"><i class="fa fa-paperclip"></i><br>草稿</router-link></li>
        <li><router-link to="/comments"><i class="fa fa-envelope"></i><br>留言</router-link></li>
      </ul>
    </aside>
    <div id="main">
      <router-view></router-view>
    </div>
  </div>
  <script>
      window.Laravel = <?php echo json_encode([
          'csrfToken' => csrf_token(),
      ]); ?>
  </script>
  <script src="/js/admin.js"></script>
</body>

</html>
