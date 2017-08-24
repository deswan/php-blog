<template>
<div id="tag-detail" class="body">
  <detail-banner :title="tag.name" :date="tag.updated_at" @edit="edit" @del="del">
  </detail-banner>
  <table class="table article-list">
    <thead>
      <tr>
        <th>最后修改日期</th>
        <th>标题</th>
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
  <pop-model :confirm-btn-text="modalData.confirmBtnText" @confirm="modalData.confirm" @close="close" :showModal="showModal">
    <template v-if="modalData.mode=='del'">
        确定删除标签 <strong>{{tag.name}}</strong> 吗？
      </template>
    <template v-else-if="modalData.mode=='edit'">
      <form>
        <div class="form-group" :class="{'has-error':!modalData.editTextValidated}">
          <label for="exampleInputEmail1">修改标签 {{tag.name}}</label>
          <input type="text" class="form-control" id="exampleInputEmail1" v-model="editMode.editText">
        </div>
      </form>
    </template>
  </pop-model>
</div>
</template>

<script>
import detailBanner from './DetailBanner.vue'
export default {
  data() {
    return {
      modalData: null,
      editMode:{
        mode:'edit',
        editText:'',
        editTextValidated:true,
        confirmBtnText: "完成",
        confirm: this.edit$1
      },
      delMode:{
        mode:'del',
        confirmBtnText: "删除",
        confirm: this.del$1
      },
      showModal:false,
      tag: {},
      articles: []
    }
  },
  created() {
    //modal
    this.modalData = this.editMode;

    this.$http.get('tags/' + this.$route.params.id).then(response => {
      this.articles = response.body.articles;
      this.tag = response.body.tag;

      this.editMode.editText = this.tag.name
    })
  },
  components:{
    'detail-banner':detailBanner
  },
  methods: {
    del$1() {
      this.$http.get('tags/' + this.$route.params.id + '/delete').then(response => {
        this.showModal = false;
        this.$nextTick(function(){
          this.$router.push({ name: 'tags' });
        })
      });
    },
    edit$1() {
      if(!this.modalData.editTextValidated) return;
      this.$http.post('tags/' + this.$route.params.id,{name:this.modalData.editText}).then(response => {
        this.tag = response.body;
        this.showModal = false;
      });
    },
    close(){
      this.showModal = false;
    },
    del() {
      this.modalData = this.delMode;
      this.showModal = true;
    },
    edit() {
      this.modalData = this.editMode;
      this.showModal = true;
    }
  },
  watch:{
    'editMode.editText'(text){
      if(text.length===0 || text.length > 20){
        this.editMode.editTextValidated = false;
        this.editMode.confirmBtnText = ''
      }else{
        this.editMode.editTextValidated = true;
        this.editMode.confirmBtnText = '完成'
      }
    }
  }
}
</script>
<style scoped lang="scss">
@import "../scss/var";
.article-list{
  margin: 0 30px;
}
</style>
