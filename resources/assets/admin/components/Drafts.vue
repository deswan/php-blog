<template>
  <div id="drafts" class="body">
      <table class="table">
          <thead>
          <tr>
              <th>最近修改时间</th>
              <th>title</th>
              <th></th>
          </tr>
          </thead>

          <tbody>
          <tr v-for="article in articles">
              <td>{{article.time}}</td>
              <td>{{article.title}}</td>
              <td>
                  <a class="btn btn-warning" href="#" role="button">删除</a>
                  <a class="btn btn-danger" href="#" role="button">编辑</a>
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
      articles:[
        {
          time:'2016/11/11',
          title:'asdsdaasddas',
          tag:['asd','sda','sdadsa']
        },
        {
          time:'2016/11/11',
          title:'asdsdaasddas',
          tag:['asd','sda','sdadsa']
        }
      ]
    }
  }
}
</script>
<style scoped lang="scss">
</style>
