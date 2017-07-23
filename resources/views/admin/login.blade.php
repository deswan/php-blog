<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="UTF-8">
  <title>Stephanie`s blog administration system</title>
  <link rel="stylesheet" href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
  <div class="login-frame">
    <img src="" class="logo">
    <form action="/admin65790/login" method="post">
      {{csrf_field()}}
      <div class="input-group">
        <label for="account" class="fa fa-user"></label>
        <input id="account" type="text" name="username" value="@if(old('username')) {{old('username')}} @endif">
      </div>
      <div class="input-group">
        <label for="password" class="fa fa-lock"></label>
        <input id="password" type="password" name="password" value="@if(old('password')) {{old('password')}}@endif">
      </div>
      @if(old('username'))
      <div class="error">账号或密码错误</div>
      @endif
      <button class="submit-button" type="submit">
        <span>login</span>
      </button>
    </form>
  </div>
<script src="/js/login.js"></script>
</body>

</html>
