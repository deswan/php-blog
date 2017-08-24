<template>
<section id="type-banner">
  <section class="type-banner-header">
    <img :src="logo" class="type-banner-header-logo">
    <div class="search-group">
      <input type="text" id="search" v-model="search">
      <label for="search" class="fa fa-search"></label>
    </div>
  </section>
  <section class="type-banner-tags-section">
    <span class="type-banner-tag" :class="{active:activeTagId==0}" @click="clickTag(0)">所有标签</span>
    <span class="type-banner-tag" v-for="tag in tags" :class="{active:activeTagId==tag.id}" @click="clickTag(tag.id)">{{tag.name}}</span>
  </section>
  <section class="type-banner-year-section">
    <span class="type-banner-year" :class="{active:activeYear==0}" @click="clickYear(0)">所有年份</span>
    <span class="type-banner-year" v-for="year in years" :class="{active:activeYear==year}" @click="clickYear(year)">{{year}}</span>
  </section>
</section>
</template>

<script>
//click-->triggerRoute(newData)-->changeData-->render
export default {
  props:['type','tags_years'],
  data(){
    return {
      logo:'',
      tags:[],
      years:[],
      activeTagId:0,
      activeYear:0,
      search:''
    };
  },
  created(){
    this.tags = this.tags_years.tags;
    this.years = this.tags_years.years;
    this.logo = this.type=='code' ? require('img/code.png') : require('img/essay.png');
    this.activeTagId = this.$route.query.tagId || 0;
    this.activeYear = this.$route.query.year || 0;
  },
  methods:{
    triggerRoute(obj){
      var params = {};
      obj.tagId && (params.tagId = obj.tagId);
      obj.year && (params.year = obj.year);
      this.$router.push({query:params});
    },
    clickTag(tagId){
      this.triggerRoute({tagId:tagId,year:this.activeYear})
    },
    clickYear(year){
      this.triggerRoute({tagId:this.activeTagId,year:year})
    }
  },
  watch:{
    $route($route){
      this.activeTagId = $route.query.tagId || 0;
      this.activeYear = $route.query.year || 0;
    },
    search(search){
      this.$emit('search',search.trim());
    },
    tags_years(){
      this.tags = this.tags_years.tags;
      this.years = this.tags_years.years;
    }
  }
}
</script>
<style scoped lang="scss">
#type-banner{
  margin:0 auto;
  width:1000px;
  max-width:100%;
}
.search-group{
  display: inline-block;
  position:relative;
  margin-left:10px;
  text-align: left;
}
#search{
  box-sizing: border-box;
  padding: 10px 20px 10px 40px;
  width: 150px;
  height: 40px;
  border: none;
  background-color: white;
  border-radius:30px;
}
#search:focus{
  outline:none
}
#search + label{
  position: absolute;
  top:50%;
  transform: translateY(-50%);
  left:15px;
  font-size: 20px;
}
.type-banner{
  &-header{
    text-align: center;
    line-height: 80px;
  }
  &-header-logo{
    width: 50px;
    vertical-align: middle
  }
  &-tags-section{
    text-align:center;
    line-height: 40px;
  }
  &-tag{
    display: inline-block;
    line-height: 30px;
    padding: 0 10px;
    background-color: white;
    transition: background-color .5s ease;
    margin-left:5px;
    &.active{
      background-color: lightgrey;
    }
    &:hover{
      cursor: pointer;
    }
  }
  &-year-section{
    text-align: center;
    line-height: 50px;
    margin-bottom: 10px;
  }
  &-year{
    display: inline-block;
    line-height: 30px;
    padding: 0 10px;
    transition: background-color .5s ease;
    margin-left:5px;
    &.active{
      background-color: lightgrey;
    }
    &:hover{
      cursor: pointer;
    }
  }
}
</style>
