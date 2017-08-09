<template>
<section id="article-section">
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
      type:String,
      default:''
    }
  },
  data() {
    return {
      articles: []
    }
  },
  created(){
    this.fetch();
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
    }
  }
}
</script>
<style scoped lang="scss">
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
