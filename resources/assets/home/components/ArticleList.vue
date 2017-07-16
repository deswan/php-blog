<template>
<section id="article-section">
  <ul class="a-list">
    <!-- <li is="article-item" v-for="article in articles"></li> -->
    <li is="article-item" class="article-item"></li>
    <li is="article-item" class="article-item"></li>
    <li is="article-item" class="article-item"></li>
    <li is="article-item" class="article-item"></li>
    <li is="article-item" class="article-item"></li>
    <li is="article-item" class="article-item"></li>
    <li is="article-item" class="article-item"></li>
    <li is="article-item" class="article-item"></li>
  </ul>
</section>
</template>

<script>
import articleItem from './ArticleItem.vue'

export default {
  data() {
    return {
      articles: []
    }
  },
  components: {
    'article-item': articleItem
  }
}
</script>
<style scoped lang="scss">
@import '../scss/myvar';
#article-section {
    width: 98%;
    padding-left: 2%;
    @media screen and (max-width:720px) {
        width: 100%;
        padding-left: 0;
    }
}
.a-list {
    display: block;
    margin: 0 auto;
    width: 1000px;
    max-width: 90%;
    @media screen and (max-width:720px) {
        max-width: 100%;
    }
}
.article-item{
  margin-bottom: 20px;
  @media screen and (max-width:720px) {
      margin-bottom: 5px;
  }
}
</style>
