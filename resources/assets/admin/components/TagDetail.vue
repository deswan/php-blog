<template>
<div id="tag-detail" class="body">
  <div class="panel panel-default">
    <div class="panel-body container-fluid">
      <div class="row">
        <h1 class="col-xs-10 head-title">{{tag.name}}</h1>
      </div>
      <div class="row">
        <time class="col-xs-10 head-title">更新时间：{{tag.updated_at}}</time>
        <button class="btn btn-warning col-xs-1" @click="edit">编辑</button>
        <button class="btn btn-danger col-xs-1" @click="del">删除</button>
      </div>
    </div>
  </div>
  <table class="table">
    <thead>
      <tr>
        <th>date</th>
        <th>title</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="article in articles">
        <td>{{article.updated_at}}</td>
        <td>{{article.title}}</td>
        <td>
          <router-link :to="'/articles/'+article.id" tag="button" class="btn btn-primary">
            &lt; &gt;
          </router-link>
        </td>
      </tr>
    </tbody>
  </table>
  <pop-model :confirm-btn-text="modalData.confirmBtnText" @confirm="modalData.confirm" ref="modal">
    <template v-if="modalData.mode=='del'">
        确定删除标签 {{tag.name}} 吗？
      </template>
    <template v-else-if="modalData.mode=='edit'">
      <form>
        <div class="form-group">
          <label for="exampleInputEmail1">修改标签 {{tag.name}}</label>
          <input type="text" class="form-control" id="exampleInputEmail1" v-model="editText">
        </div>
      </form>
    </template>
  </pop-model>
</div>
</template>

<script>
export default {
  data() {
    return {
      modalData: {
        confirmBtnText: "删除",
        confirm: null,
        mode: ''
      },
      editText:'',
      tag: {},
      articles: []
    }
  },
  created() {
    this.$http.get('admin/tags/' + this.$route.params.id).then(response => {
      this.articles = response.body.articles;
      this.tag = response.body.tag;
    })
    this.modalData.confirm = this.del$1;
  },
  methods: {
    del$1() {
      this.$http.get('admin/tags/' + this.$route.params.id + '/delete').then(response => {
        this.$router.push({
          name: 'tags'
        })
      });
    },
    edit$1() {
      this.$http.post('admin/tags/' + this.$route.params.id,{name:this.editText}).then(response => {
        this.tag = response.body;
      });
    },
    del() {
      this.modalData.confirmBtnText = '删除'
      this.modalData.confirm = this.del$1;
      this.modalData.mode = 'del';
      this.$refs.modal.show();
    },
    edit() {
      this.editText = this.tag.name
      this.modalData.confirmBtnText = '完成'
      this.modalData.confirm = this.edit$1;
      this.modalData.mode = 'edit';
      this.$refs.modal.show();
    }
  }
}
</script>
<style scoped lang="scss">
</style>
