<template>
    <div class="panel panel-default">
      <div class="panel-body container-fluid">
        <h1 class="col-xs-12 head-title" v-if="title">{{title}}</h1>
        <h2 class="col-xs-12 head-outline" v-if="subtitle">{{subtitle}}</h2>
        <div class="row head-button-row">
          <time class="col-xs-10 head-time">最后更新时间：{{date}}</time>
          <button class="col-xs-1 btn btn-warning" @click="edit">编辑</button>
        </div>
        <div class="row head-button-row">
          <p class="col-xs-10 head-tags">
            <slot></slot>
          </p>
          <button class="col-xs-1 btn btn-danger" @click="del">删除</button>
        </div>
      </div>
    </div>
</template>

<script>
export default {
  props:['title','subtitle','date'],
  data(){
    return{
    }
  },
  created(){
  },
  methods:{
    edit(){
      this.$emit('edit');
    },
    del(){
      this.$emit('del');
    }
  }
}
</script>
<style scoped lang="scss">
@import "../scss/var";
.head-title{
  font-size: 30px;
}
.head-outline{
  font-size: 20px;
}
.head-button-row{
  padding: 5px 15px;
}
</style>
