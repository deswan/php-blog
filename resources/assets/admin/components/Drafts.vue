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
              <td>{{draft.title}}</td>
              <td>
                <router-link :to="'/drafts/'+draft.id+'/edit'" class="btn btn-warning" href="#" role="button">编辑</router-link>
                  <button class="btn btn-danger" @click="del(draft)">删除</button>
              </td>
          </tr>
          </tbody>
      </table>
      <pop-model :arg="arg" @confirm="del$1" ref="modal" confirm-btn-text="删除">确定删除 {{arg.title}} 草稿吗？</pop-model>
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
    this.$http.get('admin/drafts').then(response => {
      this.drafts = response.body;
    })
  },
  methods:{
    del$1(draft){
      this.$http.post('admin/drafts/'+draft.id+'/delete').then(response => {
        this.drafts.splice(this.drafts.indexOf(draft),1);
        this.$refs.modal.hide();
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
