<template>
<li class="a-item">
  <div class="a-item-date">
    <time>
      <span class="date">12/16</span><br>
      <span class="year">2016</span>
    </time>
  </div>
  <h4 class="a-item-title">
    <span class="title">我是标题</span>
    <a class="badge" href="#">电影</a>
    <a class="badge" href="#">随笔</a>
  </h4>
  <p class="a-item-outline">
    我们很快发现，如果页面不考虑象素级
  </p>
  <time class="a-item-date-inner">2016-10-16</time>
</li>
</template>

<script>
export default {
  data() {
    return {
      articles: []
    }
  },
  mounted() {}
}
</script>
<style scoped lang="scss">
@import '../scss/myvar';

.a-item {
    background-color: white;
    padding: 25px 40px 20px 60px;
    position: relative;
    font-size: 16px;
    text-align: left;
    box-shadow: 0 0 30px lightgrey;
}
.a-item-title {
    vertical-align: middle;
    text-align: left;
    line-height: 30px;
}
.a-item-title .title{
  @include t-shadow;
  font-size: 25px;
  font-weight: bold;
  vertical-align: middle;
}
.a-item-title .badge{
  display: inline-block;
  vertical-align: middle;
  border-radius: 2px;
  padding: 0 5px;
  line-height: 22px;
  vertical-align: middle;
  font-size:12px;
  background-color: $bg;
  color:$red;
}
.a-item-date {
    box-sizing: border-box;
    position: absolute;
    top: 20px;
    left: -35px;
    width: 70px;
    height: 70px;
    padding-top: 20px;
    border-radius: 50%;
    background-color: $text-color;
    color: white;
    opacity: 1;
    text-align: center;
    line-height: 1.2;
    transition:all .5s ease-in-out;
}
.a-item-date .date {
    margin-top: 20px;
    font-size: 18px;
}
.a-item-date .year {
    color: #ccc;
    font-size: 12px;
}
.a-item-date-inner {
    font-size: 12px;
    margin: 5px 0;
    display: none;
}
@media only screen and (max-width:720px){
    .a-item{
      padding-left: 20px;
    }
    .a-item-date{
      left:-70px;
      opacity: 0;
    }
    .a-item-date-inner{
      display: block !important;
    }
}
.a-item-outline {
    font-size: 17px;
    margin-top:10px;
    height: 30px;
}
</style>
