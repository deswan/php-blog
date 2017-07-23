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
      <pop-model :arg="arg" @confirm="del$1" ref="modal" confirm-btn-text="删除">确定删除 {{arg && (arg.title || '未标题')}} 草稿吗？</pop-model>
  </div>
</template>

<script>
export default {
  data(){
    return{
      arg:null,
      drafts:[]
    }
  },
  created(){
    this.$http.get(this.appConfig.admin_path+'/drafts').then(response => {
      this.drafts = response.body;
    })
  },
  methods:{
    del$1(draft){
      this.$http.get(this.appConfig.admin_path+'/drafts/'+draft.id+'/delete').then(response => {
        this.drafts.splice(this.drafts.indexOf(draft),1);
      })
    },
    del(draft){
      this.arg = draft;
      this.$refs.modal.show();
    }
  }
}
</script>
<style scoped lang="scss">
</style>
