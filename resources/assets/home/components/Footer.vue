<template>
  <div id="footer">
    <div class="profile">
      <div class="profile-portrait">
        <img :src="protrait_src" alt="">
      </div>
      <p class="profile-name">Stephanie.W</p>
      <p class="profile-profession">Web Developer</p>
    </div>
    <address class="address">
      contact me: stephaniewang299@gmail.com
    </address>
  </div>
</template>

<script>
export default {
  data(){
    return {
      'protrait_src':require('img/portrait.png')
    }
  }
}
</script>

<style scoped lang="scss">
@import "../scss/myvar";
#footer{
height: 100px;
width: 100%;
background-color: $brown;
overflow: hidden;
}
.profile{
  width: 200px;
  height: 60px;
  margin: 10px auto 0;
  &-portrait{
    width: 40px;
    height: 100%;
    float: left;
  }
  img{
    margin-top: 5px;
    width: 100%;
  }
  &-name{
    margin-top: 10px;
    padding-left: 10px;
    font-size: 18px;
    color:$bg;
    float: left;
  }
  &-profession{
    margin-top: 5px;
    padding-left: 10px;
    font-size: 14px;
    color: grey;
    float: left;
  }
}
.address{
  font-size: 14px;
  color: lightgrey;
  font-style: normal;
  text-align: center;
}
</style>
