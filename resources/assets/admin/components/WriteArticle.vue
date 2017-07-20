<template>
<div id="write-article" class="body">
  <form action="" method="post" @submit.prevent="toSubmit">

    <input type="hidden" name="draft" :value="!!draft">

    <div id="editor"></div>

    <div class="input-group" :class="{'has-error':validate.title}">
      <span class="input-group-addon" id="basic-addon1">标题</span>
      <input type="text" name="title" class="form-control" aria-describedby="basic-addon1" @input="titleInput" v-model="title">
    </div>
    <div class="input-group" :class="{'has-error':validate.outline}">
      <span class="input-group-addon" id="basic-addon2">摘要</span>
      <input type="text" name="outline" class="form-control" aria-describedby="basic-addon2" @input="outlineInput" v-model="outline">
    </div>

    <div class="panel panel-default tag-choose-panel">
      <div class="panel-heading">
        <h3 class="panel-title">选择标签</h3>
      </div>
      <div class="panel-body">
        <ul class="nav nav-tabs">
          <li role="presentation" :class="{active:tagPanelState=='code'}"><a @click="tagPanelState='code'">code</a></li>
          <li role="presentation" :class="{active:tagPanelState=='essay'}"><a @click="tagPanelState='essay'">essay</a></li>
        </ul>

        <fieldset class="container-fluid" id="tag-choose">
          <div class="input-field row" v-if="tagPanelState=='code'">
            <label class="checkbox-inline col-xs-2" v-for="item in codeTags">
                  <input type="checkbox" id="inlineCheckbox1" :value="item.id" :checked="ifChecked(item.id)" name="coding_tags[]" :key="item.id">{{item.name}}
                </label>
          </div>
          <div class="input-field row" v-else-if="tagPanelState=='essay'">
            <label class="checkbox-inline col-xs-2" v-for="item in essayTags">
                  <input type="checkbox" id="inlineCheckbox1" :value="item.id" :checked="ifChecked(item.id)" name="essay_tags[]" :key="item.id" >{{item.name}}
                </label>
          </div>
        </fieldset>
      </div>
    </div>

    <section>
      <button class="form-submit-btn btn btn-primary" @click.prevent="validateSubmit">发布 <span class="fa fa-paper-plane"></span> </button>
        <button class="form-submit-btn btn btn-primary" type="submit" v-if="mode!='article_edit'" :class="{'transition-success':saveState==2}" @click.prevent="save"><i v-if="saveState==1" class="fa fa-refresh fa-spin fa-1x fa-fw"></i>保存</button>
    </section>
  </form>

  <pop-model :confirm-btn-text="modalData.confirmBtnText" @confirm="release" ref="modal">
    <template v-if="modalData.mode=='release'">
      确定发布文章吗？
    </template>
    <template v-if="modalData.mode=='error'">
      有内容未填写
    </template>
  </pop-model>
</div>
</template>

<script>
var E = require('wangeditor');
var TWEEN = require('@tweenjs/tween.js');
export default {
  props: {
    draft$1: {
      type: Number,
      default: 0
    }
  },
  data() {
    return {
      modalData:{
        confirmBtnText:'',
        confirm:null,
        mode:'error'
      },
      editor: null,
      tagPanelState: 'code',
      validate: {
        title: false,
        outline: false
      },
      mode:'write',
      id:0,
      title:'',
      outline:'',
      codeTags: [],
      essayTags: [],
      checkedTags:[],
      saveState: 0,
      draft: this.draft$1,
      tags:null
    }
  },
  created() {
    //tags
    this.$http.get('/admin/tags').then(response => {
      this.codeTags = response.body.coding
      this.essayTags = response.body.essay
    })
    this.mode = this.$route.name;
    this.id = this.$route.params.id || 0;
    if(this.mode == 'article_edit'){
      this.$http.get('/admin/articles/'+this.id+'/edit').then(response => {
        var article = response.body;
        this.title = article.title;
        this.outline = article.outline;
        this.checkedTags = article.tagIds;
        this.editor.txt.html(article.body)
      })
    }else if(this.mode == 'draft_edit'){
      this.$http.get('/admin/drafts/'+this.id+'/edit').then(response => {
        var article = response.body;
        this.title = article.title;
        this.outline = article.outline;
        this.body = article.body;
        this.editor.txt.html(article.body)
      })
    }
  },
  mounted() {
    this.editor = new E('#editor');
    this.editor.customConfig.uploadImgServer = '/upload' // 上传图片到服务器
    this.editor.create();
  },
  methods: {
    ifChecked(tagId){
      return !!~this.checkedTags.indexOf(tagId);
    },
    validateSubmit(){
      if(!window.$(':checked').length || !this.editor.txt.text() || !this.title || !this.outline || this.validate.title || this.validate.outline ){
        this.modalData.mode = 'error';
        this.modalData.confirmBtnText = '';
      }else{
        this.modalData.mode = 'release';
        this.modalData.confirmBtnText = '发布';
        this.modalData.confirm = this.release;
      }
      this.$refs.modal.show();
    },
    save(e) {
      if (this.saveState != 0) {
        return;
      }
      var form = document.forms[0];
      var formData = new FormData(form);
      formData.append('body', this.editor.txt.html());
      var done = response => {
        this.saveState = 2;
        this.id = response.body.id;  //更新草稿
        this.mode = 'draft_edit';
        setTimeout(() => {
          this.saveState = 0;
        }, 2000)
      }
      this.saveState = 1;
      if (this.mode == 'write') {
        this.$http.post('/admin/drafts', formData).then(done)
      } else if(this.mode == 'draft_edit'){
        this.$http.post('/admin/drafts/' + this.id, formData).then(done)
      }
    },
    release(e) {
      var form = document.forms[0];
      var formData = new FormData(form);
      formData.append('body', this.editor.txt.html());
      var done = function(response){
        this.$router.push('/articles');
      }
      if (this.mode == 'write') {
        this.$http.post('/admin/articles', formData).then(done)
      } else if(this.mode == 'draft_edit') {
        this.$http.post('/admin/drafts/release/' + this.id, formData).then(done)
      }else{
        this.$http.post('/admin/articles/' + this.id, formData).then(done)
      }
    },
    titleInput(e) {
      if (e.target.value.length >= 50 || e.target.value.length == 0) {
        this.validate.title = true;
      } else {
        this.validate.title = false;
      }
    },
    outlineInput(e) {
      if (e.target.value.length >= 100 || e.target.value.length == 0) {
        this.validate.outline = true;
      } else {
        this.validate.outline = false;
      }
    }
  }
}
</script>
<style scoped lang="scss">
.input-group {
    margin-top: 20px;
}
#tag-choose {
    font-size: 16px;
    margin: 10px 0;
}
.tag-choose-panel {
    min-height: 300px;
    margin: 20px 0;
}
#editor {
    background-color: white;
}
.form-submit-btn{
  float: right;
}
.form-submit-btn:not(:nth-child(1)){
  margin-right:20px;
}
</style>
