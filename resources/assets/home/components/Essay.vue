<template>
  <div>
    <router-view name="banner" type="essay" @search="searchText = $event"></router-view>
    <router-view name="article-list" type="essay" :search="searchText"></router-view>
    <router-view name="pagination" type="essay" v-show="!searchText"></router-view>
  </div>
</template>

<script>
//Banner : $emit(searchText)
//Essay : changeData(searText)
//Article-list : prop(this.searText)
export default {
  data(){
    return {
      searchText:''
    }
  }
}
</script>

<style lang="css">
</style>
