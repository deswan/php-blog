<template>
<li class="a-item">
  <div class="a-item-date">
    <time>
      <span class="date">{{article.month}}/{{article.day}}</span><br>
      <span class="year">{{article.year}}</span>
    </time>
  </div>
  <h4 class="a-item-title">
    <a :href="'/article/'+article.id" class="title">{{article.title}}</a>
    <router-link class="badge" :key="tag.id" :to="{name : article.type ,query:{tagId:tag.id}}" v-for="tag in article.tags">{{tag.name}}</router-link>
  </h4>
  <p class="a-item-outline">
    {{article.outline}}
  </p>
  <time class="a-item-date-inner">{{article.year}}-{{article.month}}-{{article.day}}</time>
</li>
</template>

<script>
export default {
  props:['article'],
  data() {
    return {}
  }
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
.a-item-date {
  font-family: "Hiragino Sans GB", "Microsoft YaHei",
  "WenQuanYi Micro Hei", sans-serif;
    box-sizing: border-box;
    position: absolute;
    top: 20px;
    left: -35px;
    width: 70px;
    height: 70px;
    padding-top: 20px;
    border-radius: 50%;
    background-color: $brown;
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
