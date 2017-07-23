<template>
  <div id="article-detail" class="body">
    <div class="panel panel-default">
      <div class="panel-body container-fluid">
        <div class="row">
          <h1 class="col-xs-12 head-title">{{article.title}}</h1>
        </div>
        <div class="row">
          <h2 class="col-xs-12 head-outline">{{article.outline}}</h2>
        </div>
        <div class="row head-button-row">
          <time class="col-xs-10 head-time">{{article.updated_at}}</time>
          <router-link :to="{name:'article_edit',params:{id:article.id}}" tag="button" class="col-xs-1 btn btn-warning">编辑</router-link>
        </div>
        <div class="row head-button-row">
          <p class="col-xs-10 head-tags">
            <router-link :key="tag.id" :to="'/tags/'+tag.id" tag="button" v-for="tag in article.tag" class="btn btn-default btn-xs">
              {{tag.name}}
            </router-link>
          </p>
          <button class="col-xs-1 btn btn-danger" @click="del">删除</button>
        </div>
      </div>
    </div>

    <ul class="nav nav-tabs">
      <li role="presentation" :class="{active:$route.name=='article_detail_comment'}"><router-link to="comment">评论</router-link></li>
      <li role="presentation" :class="{active:$route.name=='article_detail_statistic'}"><router-link to="statistic">流量统计</router-link></li>
    </ul>
    <router-view :is-component="true" :article-id="article.id"></router-view>

    <pop-model :confirm-btn-text="modalData.confirmBtnText" @confirm="modalData.confirm" ref="modal">
          确定删除文章 {{article.title}} 吗？
    </pop-model>

  </div>
</template>

<script>
export default {
  data(){
    return{
      modalData:{
        confirmBtnText:'删除',
        confirm:null
      },
      article:{}
    }
  },
  created(){
    this.$http.get(this.appConfig.admin_path+'/articles/'+this.$route.params.id).then(response => {
        this.article = response.body;
    })
    this.modalData.confirm = this.del$1;
  },
  methods:{
    del(){
      this.$refs.modal.show();
    },
    del$1(){
      this.$http.get(this.appConfig.admin_path+'/articles/'+this.$route.params.id+'/delete').then(response => {
          this.$router.push({name:'articles'});
      })
    }
  }
}
</script>
<style scoped lang="scss">
.head-title{
  font-size: 30px;
}
.head-outline{
  font-size: 20px;
}
.head-button-row{
  padding: 5px 0;
}
</style>
