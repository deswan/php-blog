<template>
<div id="write-article" class="body">
  <form action="" method="post" @submit.prevent="toSubmit">

    <input type="hidden" name="draft" :value="!!draft">

    <div id="editor"></div>

    <div class="input-group"  :class="{'has-error':validate.title}">
      <span class="input-group-addon" id="basic-addon1">标题</span>
      <input type="text" name="title" class="form-control" aria-describedby="basic-addon1" @input="titleInput">
    </div>
    <div class="input-group" :class="{'has-error':validate.outline}">
      <span class="input-group-addon" id="basic-addon2">摘要</span>
      <input type="text" name="outline" class="form-control" aria-describedby="basic-addon2" @input="outlineInput">
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
                  <input type="checkbox" id="inlineCheckbox1" :value="item.id" name="coding_tags[]" :key="item.id">{{item.name}}
                </label>
          </div>
          <div class="input-field row" v-else-if="tagPanelState=='essay'">
            <label class="checkbox-inline col-xs-2" v-for="item in essayTags">
                  <input type="checkbox" id="inlineCheckbox1" :value="item.id" name="essay_tags[]" :key="item.id">{{item.name}}
                </label>
          </div>
        </fieldset>
      </div>
    </div>

    <section class="container-fluid">
      <div class="row">
        <button class="btn btn-primary col-xs-2  col-xs-offset-7" type="submit" :class="{'transition-success':saveState==2}" @click.prevent="save"><i v-if="saveState==1" class="fa fa-refresh fa-spin fa-1x fa-fw"></i>保存</button>
        <button class="btn btn-primary col-xs-2  col-xs-offset-1" type="submit" @click.prevent="release">发布
        <span class="fa fa-paper-plane"></span>
      </button>
      </div>
    </section>
  </form>
</div>
</template>

<script>
var E = require('wangeditor');
var TWEEN = require('@tweenjs/tween.js');
export default {
  props:{
    draft$1:{
      type:Number,
      default:0
    }
  },
  data() {
    return {
      editor: null,
      tagPanelState: 'code',
      validate:{
        title:false,
        outline:false
      },
      codeTags: [],
      essayTags: [],
      saveState:0,
      draft:this.draft$1
    }
  },
  created() {
    //tags
    this.$http.get('/admin/tags').then(response => {
      this.codeTags = response.body.coding
      this.essayTags = response.body.essay
    })
  },
  mounted() {
    this.editor = new E('#editor');
    this.editor.customConfig.uploadImgServer = '/upload' // 上传图片到服务器
    this.editor.create();
  },
  methods: {
    save(e) {
      if(this.saveState!=0){return;}
      var form = document.forms[0];
      var formData = new FormData(form);
      formData.append('body',this.editor.txt.html());
      var done = response => {
        this.saveState=2;
        this.draft = response.body.id;
        setTimeout(()=>{
          this.saveState = 0;
        },2000)
      }
      this.saveState=1;
      if(!this.draft){
        this.$http.post('/admin/drafts',formData).then(done)
      }else{
        this.$http.post('/admin/drafts/'+this.draft,formData).then(done)
      }
    },
    release(e) {

    },
    titleInput(e){
      if(e.target.value.length>=50 || e.target.value.length==0){
        this.validate.title = true;
      }else{
        this.validate.title = false;
      }
    },
    outlineInput(e){
      if(e.target.value.length>=100 || e.target.value.length==0){
        this.validate.outline = true;
      }else{
        this.validate.outline = false;
      }
    },
    toSubmit(e) {
      var form = e.target;
      for (var i in this.maxLength) {
        if (this.maxLength.hasOwnProperty(i)) { //filter,只输出man的私有属性
          var l = $(form).find('[name=' + i + ']').val().length;
          if (l > this.maxLength[i]) {
            return;
          } else if (l === 0) {
            alert('字段不可为空');
            return;
          }

        }
      }
      if ($(form).find('[name=text]').val().length === 0) {
        alert('字段不可为空');
      } else if ($(form).find('[type=checkbox]:checked').length === 0) {
        alert('须选择至少一个分类');
      } else {
        $.ajax({
          url: '/admin/articles/validate_title',
          data: {
            title: $(form).find('[name=title]').val()
          },
          complete(xhr) {
            if (xhr.status === 200) {
              form.submit();
            } else if (xhr.status === 422) {
              alert('该标题已被使用')
            }
          }
        })
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
</style>
