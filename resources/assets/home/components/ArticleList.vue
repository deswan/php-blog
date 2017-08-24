<template>
<section id="article-list-wrapper">
  <ul class="a-list">
      <li is="article-item" class="article-item" :article="article" v-for="article in articles" :key="article.id"></li>
  </ul>
</section>
</template>

<script>
import articleItem from './ArticleItem.vue'

export default {
  props:{
    type:{
      type:String,
      default:''
    },
    search:{
      type:String
    },
    articles_1:{
      type:Array
    }
  },
  data() {
    return {
      articles: []
    }
  },
  created(){
    this.articles = this.articles_1;
  },
  components: {
    'article-item': articleItem
  },
  methods:{
    fetch(){
      var params = {} , query = this.$route.query;
      query.tagId && (params.tagId = query.tagId);
      query.year && (params.year = query.year);
      this.search && (params.search = this.search);
      query.page && (params.page = query.page);
      this.$http.get('/getArticles/'+this.type,{params:params}).then(response=>{
        this.articles = response.body;
        if(query.page){
          this.$nextTick(function(){  //待渲染完成后再scroll，不然没效果
              window.$.scrollTo(document.getElementById('type-banner').clientHeight,'200');
          })
        }
      });
    }
  },
  watch:{
    $route(to){
      this.fetch();
    },
    search(){
      this.fetch();
    },
    articles_1(){
      this.articles = this.articles_1;
    }
  }
}
</script>
<style lang="scss">
@import "../scss/myvar";
#article-list-wrapper {
    padding-left: 2%;
    @media screen and (max-width:$media-width) {
        padding-left: 0;
    }
}
.a-list {
    display: block;
    margin: 0 auto;
    width: 1000px;
    max-width: 90%;
    @media screen and (max-width:$media-width) {
        max-width: 100%;
    }
}
.article-item{
  margin-bottom: 30px;
  @media screen and (max-width:$media-width) {
      margin-bottom: 5px;
  }
}
</style>
