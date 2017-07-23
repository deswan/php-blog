<template>
  <div>
    <router-view name="banner" type="code" @search="searchText = $event"></router-view>
    <router-view name="article-list" type="code" :search="searchText"></router-view>
    <router-view name="pagination" type="code" v-show="!searchText"></router-view>
  </div>
</template>

<script>
//Banner : $emit(searchText)
//Code : changeData(searText)
//Article-list : prop(this.searText)
export default {
  data(){
    return {
      searchText:''
    }
  }
}
</script>
<style>
body{
  background-image:none;
}
</style>
