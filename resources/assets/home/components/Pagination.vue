<template>
<section class="pagination">
<span class="fa fa-angle-left pagination-control" :class="{disabled:page<2}" @click="triggerRoute(page-1)"></span>
<span class="pagination-item" :class="{active:page==p}" @click="triggerRoute(p)" v-for="p in pageSum">{{p}}</span>
<span class="fa fa-angle-right pagination-control" :class="{disabled:page>pageSum-1}" @click="triggerRoute(page+1)"></span>
</section>
</template>

<script>
//click-->triggerRoute(newPage)-->changeData:page-->render
export default {
  props:{
    type:{
      type:String,
      default:''
    }
  },
  data() {
    return {
      page:1,
      pageSum:0
    }
  },
  created(){
    this.page = this.$route.query.page || 1;  //初始化当前页数
    this.fetch();
  },
  methods:{
    triggerRoute(page){
      if( page < 1 || page > this.pageSum ) return;
      var params = {} , query = this.$route.query;
      query.tagId && (params.tagId = query.tagId);
      query.year && (params.year = query.year);
      params.page = page;
      this.$router.push({name:this.type || 'index',query:params});
    },
    fetch(){
      var params = {} , query = this.$route.query;;
      query.tagId && (params.tagId = query.tagId);
      query.year && (params.year = query.year);
      this.$http.get('/getPageSum/'+this.type,{params:params}).then(response => {
        this.pageSum = response.body; //总页数
      })
    }
  },
  watch:{
    $route(to,from){
      if(to.query.tagId!==from.query.tagId || to.query.year!==from.query.year){
        this.fetch();
      }
      this.page = to.query.page || 1;
    }
  }
}
</script>
<style scoped lang="scss">
@import "../scss/myvar";
.pagination{
  @include t-shadow;
  display: flex;
  width: 1100px;
  max-width: 95%;
  margin:30px auto;
  height: 50px;
  flex-flow:row nowrap;
  justify-content: center;
  align-items: stretch;
  &-item{
    flex-grow:0;
    flex-shrink:0;
    flex-basis:50px;
    line-height: 50px;
    font-size: 20px;

    &.active{
      background-color: lightgrey;
    }
    &.active:hover{
      cursor: default;
    }
  }
  &-control{
    flex-grow:1;
    flex-shrink:0;
    flex-basis:50px;
    line-height: 50px;
    font-size: 25px;

    &.disabled{
      color:lightgrey;
    }
    &.disabled:hover{
      background-color: transparent;
      cursor: default;
    }
  }
  &-item:hover,&-control:hover{
    background-color: lightgrey;
    cursor: pointer;
  }
  &-item,&-control{
    text-align: center;
    transition: background-color .5s ease;
  }
}
</style>
