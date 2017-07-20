<template>
  <div id="articles" class="body">
      <table class="table">
          <thead>
          <tr>
              <th>date</th>
              <th>title</th>
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
    this.$http.get('admin/articles').then(response => {
        this.articles = response.body;
    })
  }
}
</script>
<style scoped lang="scss">

</style>
