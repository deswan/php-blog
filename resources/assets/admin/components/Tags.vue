<template>
<div id="category" class="container-fluid">
  <div class="row">
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container-fluid">
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

          <form class="navbar-form navbar-left" name="search-form">
            <div class="form-group">
              <input type="text" name="search-text" class="form-control" placeholder="Search" v-model="search">
            </div>
          </form>

          <form class="navbar-form navbar-right" @submit.prevent="add" name="add-form">
            <div class="form-group"  :class="{'has-error':!addValidated}">
              <input type="text" name="name" class="form-control" v-model="addText">
            </div>
            <label class="radio-inline">
              <input type="radio" name="type" id="inlineRadio1" value="0" checked> coding
            </label>
            <label class="radio-inline">
              <input type="radio" name="type" id="inlineRadio2" value="1"> essay
            </label>
            <button type="submit" class="btn btn-default">添加</button>
          </form>

          <ul class="nav navbar-nav navbar-right">
            <li><i class="logo fa fa-plus" aria-hidden="true"></i></li>
          </ul>
        </div>
      </div>
    </nav>
    <section class="body">
      <div class="panel panel-default tag-panel">
        <div class="panel-heading">code</div>
        <ul class="list-group">
          <router-link :key="item.id" :to="'/tags/'+item.id" v-for="item in coding" class="list-group-item" accesskey="">{{item.name}}</router-link>
        </ul>
      </div>
      <div class="panel panel-default tag-panel">
        <div class="panel-heading">essay</div>
        <ul class="list-group">
          <router-link :key="item.id" :to="'/tags/'+item.id" v-for="item in essay" class="list-group-item" accesskey="">{{item.name}}</router-link>
        </ul>
      </div>
    </section>
  </div>
</div>
</template>
<script>
export default {
  data() {
    return {
      coding: [],
      essay:[],
      _coding: [],
      _essay:[],
      search:'',
      addText:'',
      tagMaxLength: 20,
      addValidated:true //for class
    }
  },
  created(){
    this.$http.get(this.appConfig.admin_path+'/tags').then(response => {
      this._coding = response.body.coding || [];
      this._essay = response.body.essay || [];
      this.coding = this._coding;
      this.essay = this._essay;
    })
  },
  methods: {
    add(e) {
      if (!this.addValidated || this.addText.trim().length===0) return;
      this.$http.post(this.appConfig.admin_path+'/tags',new FormData(document.forms['add-form'])).then(response => {
        this.addText = '';
        if(response.body.type==0){
          this._coding.unshift(response.body);
        }else if(response.body.type==1){
          this._essay.unshift(response.body);
        }
        //将列表初始化为全部显示，避免search的影响
        this.coding = this._coding;
        this.essay = this._essay;

      },response => {
        alert('该名称已被使用')
      })
    }
  },
  watch:{
    search(text){
      if(!(text = text.trim())){
        this.coding = this._coding;
        this.essay = this._essay;
      }else{
        var words = text.replace(/\s+/g,' ').split(' '),regText = '';
        for(var i=0,l=words.length;i<l;i++){
          regText += '.*'+words[i]
        }
        regText += '.*';
        var regEx = new RegExp(regText,'i');
        this.coding = this._coding.filter((item) => {
          return regEx.test(item.name)
        })
        this.essay = this.essay.filter((item) => {
          return regEx.test(item.name)
        })
      }
    },
    addText(text){
      if(text.length > this.tagMaxLength){
        this.addValidated = false;
      }else{
        this.addValidated = true;
      }
    }
  }
}
</script>
<style scoped lang="scss">
.tag-panel {
    width: 50%;
    float: left;
    margin-top: 70px;
}
.navbar-fixed-top{
    padding-left: 100px;
}
.logo {
    font-size: 30px;
    line-height: 50px;
}
</style>
