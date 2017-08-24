<template>
<div id="write-article">
  <form class="write-form" action="" method="post" @submit.prevent="toSubmit">
    <div id="editor1"></div>
    <div id="editor2" style="height:600px;"></div>
    <div class="input-group" :class="{'has-error':validate.titleError}">
      <span class="input-group-addon" id="basic-addon1">标题</span>
      <input type="text" name="title" class="form-control" aria-describedby="basic-addon1" @input="titleInput" v-model="title">
    </div>
    <div class="input-group" :class="{'has-error':validate.outlineError}">
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
                  <input type="checkbox" :value="item.id" name="coding_tags[]" v-model="codingCheckedTags">{{item.name}}
                </label>
          </div>
          <div class="input-field row" v-else-if="tagPanelState=='essay'">
            <label class="checkbox-inline col-xs-2" v-for="item in essayTags">
                  <input type="checkbox" :value="item.id" name="essay_tags[]" v-model="essayCheckedTags">{{item.name}}
                </label>
          </div>
        </fieldset>
      </div>
    </div>

    <section class="clearfix">
      <button class="form-submit-btn btn btn-primary" @click.prevent="release">发布 <span class="fa fa-paper-plane"></span> </button>
        <button class="form-submit-btn btn btn-primary" type="submit" v-if="mode!='article_edit'" :class="{'transition-success':saveState==2}" @click.prevent="save"><i v-if="saveState==1" class="fa fa-refresh fa-spin fa-1x fa-fw"></i>保存</button>
    </section>
  </form>

  <pop-model :confirm-btn-text="modalData.mode=='release' ? '发布' : ''" @confirm="release$1" @close="close" :showModal="showModal">
    <template v-if="modalData.mode=='release'">
      确定发布文章吗？
    </template>
    <template v-if="modalData.mode=='error'">
      有内容未填写 或 未通过验证
    </template>
  </pop-model>
</div>
</template>

<script>
var E = require('wangeditor');
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
        mode:'error'
      },
      showModal:false,
      editor: null,
      tagPanelState: 'code',
      validate: {
        titleError: false,
        outlineError: false
      },
      mode:'write',
      id:0,
      title:'',
      outline:'',
      codeTags:[],
      essayTags:[],
      codingCheckedTags: [],
      essayCheckedTags: [],
      saveState: 0
    }
  },
  created() {
    //tags
    this.$http.get('tags').then(response => {
      this.codeTags = response.body.coding
      this.essayTags = response.body.essay
    })
    this.mode = this.$route.name;
    this.id = this.$route.params.id || 0; //当前草稿id或文章id，取决于mode的值
  },
  mounted() {
    this.editor = new E('#editor1','#editor2');
    this.editor.customConfig.uploadImgServer = '/admin65790/uploadFile' // 上传图片路径
    this.editor.customConfig.uploadImgMaxSize = 10 * 1024 * 1024; //限制10M
    this.editor.customConfig.uploadImgHeaders = {
        'X-CSRF-TOKEN': window.Laravel.csrfToken   // 属性值会自动进行 encode ，此处无需 encode
    };
    this.editor.customConfig.uploadFileName = 'image'
    this.editor.create();

    var modeStrat = {
      write(){

      },
      article_edit(){
        this.$http.get('articles/'+this.id+'/edit').then(response => {
          var article = response.body;
          this.title = article.title;
          this.outline = article.outline;
          if(article.type == 'essay'){
            this.essayCheckedTags = article.tagIds;
          }else{
            this.codingCheckedTags = article.tagIds;
          }
          this.editor.txt.html(article.body)
        })
      },
      draft_edit(){
        this.$http.get('drafts/'+this.id+'/edit').then(response => {
          var article = response.body;
          this.title = article.title;
          this.outline = article.outline;
          this.body = article.body;
          this.editor.txt.html(article.body)
        })
      }
    }

    //初始化内容
    modeStrat[this.mode].call(this);

    //编辑框鼠标滚动体验优化
    var contentEditor = document.getElementsByClassName('w-e-text')[0];
    function mousewheelHandler(e){
      var dom = e.currentTarget,down;
      if(e.wheelDelta){
        down = e.wheelDelta < 0;
      }else if(e.detail){
        down = e.detail > 0;
      }
      if(down && dom.scrollTop >= dom.scrollHeight - dom.clientHeight - 1){
        e.preventDefault();
      }
    }
    contentEditor.onmousewheel = mousewheelHandler;
    contentEditor.addEventListener('DOMMouseWheel',mousewheelHandler);
  },
  methods: {
    close(){
      this.showModal = false;
    },
    release(){
      var valid = (this.codingCheckedTags.length>0 || this.essayCheckedTags.length>0) && this.editor.txt.text().length > 0 && !this.validate.titleError && !this.validate.outlineError
      if(!valid){
        this.modalData.mode = 'error';
      }else{
        this.modalData.mode = 'release';
      }
      this.showModal = true;
    },
    save(e) {
      if (this.saveState != 0) {
        return;
      }
      var form = document.forms[0];
      var formData = new FormData(form);
      formData.append('body', this.editor.txt.html());
      this.saveState = 1; //正在获取

      var done = response => {
        this.saveState = 2; //获取完毕，显示动画效果

        this.id = response.body.id;
        this.mode = 'draft_edit';

        setTimeout(() => {
          this.saveState = 0; //save按钮可用
        }, 2000)
      }
      if (this.mode == 'write') { //存储为草稿
        this.$http.post('drafts', formData).then(done)
      } else if(this.mode == 'draft_edit'){ //更新草稿
        this.$http.post('drafts/' + this.id, formData).then(done)
      }
    },
    release$1(e) {
      var form = document.forms[0];
      var formData = new FormData(form);
      formData.append('body', this.editor.txt.html());
      var done = function(response){
        this.$nextTick(function(){
          this.$router.push('/articles');
        })
      }
      if (this.mode == 'write') {
        this.$http.post('articles', formData).then(done)  //新增文章
      } else if(this.mode == 'draft_edit') {
        this.$http.post('drafts/release/' + this.id, formData).then(done) //将草稿发表
      }else if(this.mode == 'article_edit'){
        this.$http.post('articles/' + this.id, formData).then(done) //更新文章
      }
    },
    titleInput(e) {
      if (e.target.value.length >= 50 || e.target.value.length == 0) {
        this.validate.titleError = true;
      } else {
        this.validate.titleError = false;
      }
    },
    outlineInput(e) {
      if (e.target.value.length >= 100 || e.target.value.length == 0) {
        this.validate.outlineError = true;
      } else {
        this.validate.outlineError = false;
      }
    }
  },
  watch:{
    codingCheckedTags(to,from){
      if(to.length>from.length){
        this.essayCheckedTags = [];
      }
    },
    essayCheckedTags(to,from){
      if(to.length>from.length){
        this.codingCheckedTags = [];
      }
    }
  }
}
</script>
<style scoped lang="scss">
@import "../scss/var";
#write-article{
  @include content-box;
}
#editor2{
  background: white;
  border: solid 1px lightgrey;
}
.write-form{
  margin-bottom: 20px;
}
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
