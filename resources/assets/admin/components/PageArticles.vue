<template>
  <div id="articles">
      <table class="table">
          <thead>
          <tr>
              <th>最后修改日期</th>
              <th>标题</th>
              <th>tag</th>
              <th></th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="article in articles">
              <td>{{article.updated_at}}</td>
              <td>{{article.title}}</td>
              <td>
                <router-link :key="tag.id" :to="'/tags/'+tag.id" tag="button" v-for="tag in article.tag" class="btn btn-default btn-xs">
                  {{tag.name}}
                </router-link>
              </td>
              <td>
                <router-link :to="'/articles/'+article.id" tag="button"class="btn btn-primary">
                  < >
                </router-link>
              </td>
          </tr>
          </tbody>
      </table>
  </div>
</template>

<script>
export default {
  data(){
    return{
      articles:[]
    }
  },
  created(){
    this.$http.get('articles').then(response => {
        this.articles = response.body;
    })
  }
}
</script>
<style scoped lang="scss">
@import "../scss/var";
#articles{
  @include content-box;
}
</style>
