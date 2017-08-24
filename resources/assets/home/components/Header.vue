<template>
<header id="header">
  <ul id="header-ul">
    <li class="header-li" id="header-logo-li">
      <a class="header-li-a" href="/">
        <img class="header-li-img" :src="starImg">
        <span class="header-li-text"></span>
      </a>
    </li>
    <li class="header-li">
      <a class="header-li-a" href="/code">
        <img class="header-li-img" :src="codeImg">
        <span class="header-li-text">编程</span>
      </a>
    </li>
    <li class="header-li">
      <a class="header-li-a" href="/essay">
        <img class="header-li-img" :src="essayImg">
        <span class="header-li-text">闲话</span>
      </a>
    </li>
  </ul>
</header>
</template>

<script>
export default {
  data() {
    return {
      codeImg:require('img/code.png'),
      essayImg:require('img/essay.png'),
      starImg:require('img/star.png')
    }
  }
}
</script>
<style scoped lang="scss">
@import '../scss/myvar';

#header {
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1000;
    width: 100%;

    background-color: whitesmoke;
    opacity: 0.8;
}
#header-ul {
    font-size: 0;
}
.header-li {
    display: inline-block;
    font-size: $header-font-size;
    width: $header-li-width;
}
.header-li-a {
    display: block;
    width: 100%;
    text-align: center;
    line-height: $header-height;
    color: $header-font-color;
    transition: background-color 0.3s ease;
}
.header-li-img {
    height: 30px;
    vertical-align: middle;
}
.header-li-text {
    vertical-align: middle;
}
#header-logo-li {
    position: absolute;
    left: 50%;
    margin-left: -$header-li-width/2;
}
.header-li:not(#header-logo-li) .header-li-a:hover {
    background-color: lightgrey;
}
@media screen and (max-width:$media-width) {
    .header-li {
        width: calc((100% - 70px) / 2);
    }
    #header-logo-li {
        position: static;
        margin: 0;
        width: 70px;
        .header-li-a{
        }
    }
}
</style>
