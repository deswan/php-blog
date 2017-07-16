<template>
<div id="write-article" class="body">
  <form action="" method="post" @submit.prevent="toSubmit">
    <div id="editor"></div>
    <div class="input-group">
      <span class="input-group-addon" id="basic-addon1">标题</span>
      <input type="text" name="title" class="form-control" aria-describedby="basic-addon1">
    </div>
    <div class="input-group">
      <span class="input-group-addon" id="basic-addon2">摘要</span>
      <input type="text" name="summary" class="form-control" aria-describedby="basic-addon2">
    </div>
    <div class="panel panel-default tag-choose-panel">
      <div class="panel-heading">
        <h3 class="panel-title">选择标签</h3>
      </div>
      <div class="panel-body">
        <ul class="nav nav-tabs">
          <li role="presentation" class="active"><a href="#">code</a></li>
          <li role="presentation"><a href="#">essay</a></li>
        </ul>
        <fieldset class="container-fluid" id="tag-choose">
          <div class="input-field row" id="firstLevel">
            <label class="checkbox-inline col-xs-2">
                  <input type="checkbox" id="inlineCheckbox1" value="option1"> 1
                </label>
            <label class="checkbox-inline col-xs-2">
                  <input type="checkbox" id="inlineCheckbox1" value="option1"> 1
                </label>
          </div>
        </fieldset>
      </div>
    </div>

    <section class="container-fluid">
      <div class="row">
        <button class="btn btn-primary col-xs-2  col-xs-offset-7" type="submit" @click="draft=1">保存</button>
      <button class="btn btn-primary col-xs-2  col-xs-offset-1" type="submit" @click="draft=0">发布
        <span class="fa fa-paper-plane"></span>
      </button>
      </div>
    </section>

    <input type="hidden" name="draft" :value="draft" />
  </form>
</div>
</template>

<script>
var E = require('wangeditor');
export default {
  data() {
    return {
      maxLength: {
        title: 20,
        short: 50
      },
      draft: 0,
      firstLevel: -1,
      secondLevel: [],
      secondLevels: {}
    }
  },
  mounted() {
    $.get('/admin/categories/data', (data) => {
      this.secondLevels = data;
      this.secondLevel = this.secondLevels.coding;
    })
    var editor = new E('#editor');
    editor.create()
  },
  methods: {
    updateLevel(e) {
      if (this.firstLevel === 1) {
        this.secondLevel = this.secondLevels.coding;
      } else {
        this.secondLevel = this.secondLevels.essay;
      }
    },
    checkCoding(e) {
      this.secondLevel = this.secondLevels.coding;
    },
    checkEssay(e) {
      this.secondLevel = this.secondLevels.essay;
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
.radio-inline{
  height: 35px;
}
#tag-choose{
  font-size: 16px;
  margin: 10px 0;
}
.tag-choose-panel{
  margin: 20px 0;
}
#editor{
  background-color: white;
}
</style>
