<template>
<section id="banner">
  <!-- <div class="effect"></div>
  <div class="effect"></div>
  <div class="effect"></div> -->
  <h1 id="banner-text">STEPHANIE<br><span class="banner-subtext">WALK IN STREET</span></h1>
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
  height: 320px;
  margin: 0px auto;
  padding-top:70px;
  text-align: center;
  font-family: "Hiragino Sans GB", "Microsoft YaHei","WenQuanYi Micro Hei", sans-serif;
  background: url(../../images/butterfly.svg) center/400px no-repeat;
  color:$brown;
  .effect {
      position: absolute;
      height: 80px;
      width: 100px;
      background-color: rgba(255,255,255,0.6);
      box-shadow: inset 0 0 30px 0 #e0e0e0;
  }
  .effect:nth-of-type(1) {
      transform: translateX(40px) translateY(-5px);
  }
  .effect:nth-of-type(2) {
      width: 150px;
      transform: translateX(110px) translateY(70px);
  }
  .effect:nth-of-type(3) {
      transform: translateX(245px) translateY(140px);
  }
  @media screen and (max-width:550px){
    font-size: 0.7em;
    padding-top:90px;
  }
}
#banner-text{
  margin: 0;
  font-size: 5em;
}
.banner-subtext{
  font-size: 0.7em;
}
</style>
