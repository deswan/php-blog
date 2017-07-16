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
              <td>{{article.time}}</td>
              <td>{{article.title}}</td>
              <td>
                <span v-for="tag in article.tag">{{tag}}</span>
              </td>
              <td>
                  <button class="btn btn-primary" type="submit">查看</button>
                  <button class="btn btn-primary" type="submit">统计</button>
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
table{
  margin-left: 5px;
}
  a{
    padding-left: 10px;
    padding-right: 10px;
  }

</style>
