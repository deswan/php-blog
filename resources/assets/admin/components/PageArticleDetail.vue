<template>
  <div id="article-detail">
    <detail-banner :title="article.title" :subtitle="article.outline" :date="article.updated_at" @edit="edit" @del="del">
      <router-link :key="tag.id" :to="'/tags/'+tag.id" tag="button" v-for="tag in article.tag" class="btn btn-default btn-xs">
        {{tag.name}}
      </router-link>
    </detail-banner>
    <statistic :article-id="article.id" v-if="article.id"></statistic>
    <pop-model :confirm-btn-text="modalData.confirmBtnText" @confirm="confirmDel" @close="closeModal" :showModal="showModal">
          确定删除文章<strong>{{article.title}}</strong> 吗？
    </pop-model>

  </div>
</template>

<script>
import statistic from './Statistics';
import detailBanner from './DetailBanner';
export default {
  data(){
    return{
      modalData:{
        confirmBtnText:'删除',
      },
      confirmDel:null,
      showModal:false,
      article:{}
    }
  },
  components:{
    statistic,
    'detail-banner':detailBanner
  },
  created(){
    this.$http.get('articles/'+this.$route.params.id).then(response => {
        this.article = response.body;
    })
    this.confirmDel = this.del$1;
  },
  methods:{
    edit(){
      this.$router.push({
        name:'article_edit',
        params:{id:this.article.id}
      });
    },
    del(){
      this.showModal = true;
    },
    closeModal(){
      this.showModal = false;
    },
    del$1(){
      this.$http.get('articles/'+this.$route.params.id+'/delete').then(response => {
          this.showModal = false;
          this.$nextTick(function(){
            this.$router.push({name:'articles'});
          })
      })
    }
  }
}
</script>
<style scoped lang="scss">
@import "../scss/var";
</style>
