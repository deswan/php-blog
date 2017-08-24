<template>
  <div id="drafts">
      <table class="table">
          <thead>
          <tr>
              <th>最近修改时间</th>
              <th>标题</th>
              <th></th>
          </tr>
          </thead>

          <tbody>
          <tr v-for="draft in drafts">
              <td>{{draft.updated_at}}</td>
              <td>{{draft.title || '未标题'}}</td>
              <td>
                <router-link :to="'/drafts/'+draft.id+'/edit'" class="btn btn-warning" href="#" role="button">编辑</router-link>
                  <button class="btn btn-danger" @click="del(draft)">删除</button>
              </td>
          </tr>
          </tbody>
      </table>
      <pop-model :confirmArg="arg" @confirm="del$1" :showModal="showModal" confirm-btn-text="删除">确定删除草稿 <strong>{{arg && (arg.title || '未标题')}}</strong> 吗？</pop-model>
  </div>
</template>

<script>
export default {
  data(){
    return{
      showModal:false,
      arg:null,
      drafts:[]
    }
  },
  created(){
    this.$http.get('drafts').then(response => {
      this.drafts = response.body;
    })
  },
  methods:{
    del$1(draft){
      this.$http.get('drafts/'+draft.id+'/delete').then(response => {
        this.drafts.splice(this.drafts.indexOf(draft),1);
        this.showModal = false;
      })
    },
    del(draft){
      this.arg = draft;
      this.showModal = true;
    }
  }
}
</script>
<style scoped lang="scss">
@import "../scss/var";
#drafts{
  @include content-box;
}
</style>
