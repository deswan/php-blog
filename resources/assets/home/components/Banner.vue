<template>
<section id="banner">
  <h1 id="banner-text"><span class="text-1">STEPHANIE</span><br><span class="text-2">WALK IN THE STREET</span></h1>
</section>
</template>

<script>
export default {
}
</script>
<style scoped lang="scss">
@import "../scss/myvar";
#banner {
  box-sizing: border-box;
  display: block;
  width: 600px;
  max-width: 100%;
  height: 400px;
  margin: 0px auto;
  padding-top:130px;
  text-align: center;
  font-family: "Hiragino Sans GB", "Microsoft YaHei","WenQuanYi Micro Hei", sans-serif;
  background: url(../../images/butterfly.svg) center/400px no-repeat;
  color:$brown;
  @media screen and (max-width:550px){
    font-size: 0.7em;
    padding-top:90px;
  }
}
#banner-text{
  margin: 0;
}
.text-1{
  font-size: 2.5em;
}
.text-2{
  font-size: 0.8em;
}
</style>
