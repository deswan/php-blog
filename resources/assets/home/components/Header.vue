<template>
<header id="header">
  <ul id="header-ul">
    <li class="header-li"><a class="header-li-a" href="#"><img class="header-li-img" :src="imgs[0]"><span class="header-li-text">CODE</span></a></li>
    <li class="header-li"><a class="header-li-a" href="#"><img class="header-li-img" :src="imgs[1]"><span class="header-li-text">ESSAY</span></a></li>
    <li class="header-li" id="header-logo-li"><a class="header-li-a" href="#"><img class="header-li-img" :src="imgs[2]"><span class="header-li-text"></span></a></li>
  </ul>
</header>
</template>

<script>
export default {
  data() {
    return {
      imgs: [
        require('img/f1-category-02.png'),
        require('img/f1-category-03.png'),
        require('img/star.png'),
      ]
    }
  }
}
</script>
<style scoped lang="scss">
@import '../scss/myvar';
#header {
    position: fixed;
    top:0;
    left:0;
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
    font-size: 16px;
    width: 100px;
}
.header-li-a {
    display: block;
    width: 100%;
    text-align: center;
    line-height: 50px;
    color:black;
    transition:background-color .3s ease;
}
.header-li-img {
    height: 30px;
    vertical-align: middle;
}
.header-li-text {
    vertical-align: middle;
}
#header-logo-li{
    position:absolute;
    left:50%;
    margin-left: -50px;
}
.header-li:not(#header-logo-li) .header-li-a:hover {
    background-color: lightgrey;
}
@media screen and (max-width:720px){
  .header-li{
    width: 50% !important;
  }
  #header-logo-li{
    display: none;
  }
}
</style>
