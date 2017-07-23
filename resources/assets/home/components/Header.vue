<template>
<header id="header">
  <ul id="header-ul">
    <li class="header-li">
      <router-link class="header-li-a" to="/code" v-if="!disableRouter">
        <img class="header-li-img" :src="codeImg">
        <span class="header-li-text">CODE</span>
      </router-link>
      <a class="header-li-a" href="/code" v-else>
        <img class="header-li-img" :src="codeImg">
        <span class="header-li-text">CODE</span>
      </a>
    </li>
    <li class="header-li">
      <router-link class="header-li-a" to="/essay" v-if="!disableRouter">
        <img class="header-li-img" :src="essayImg">
        <span class="header-li-text">ESSAY</span>
      </router-link>
      <a class="header-li-a" href="/essay" v-else>
        <img class="header-li-img" :src="essayImg">
        <span class="header-li-text">ESSAY</span>
      </a>
    </li>
    <li class="header-li" id="header-logo-li">
      <router-link class="header-li-a" to="/" v-if="!disableRouter">
        <img class="header-li-img" :src="starImg">
        <span class="header-li-text"></span>
      </router-link>
      <a class="header-li-a" href="/" v-else>
        <img class="header-li-img" :src="starImg">
        <span class="header-li-text"></span>
      </a>
    </li>
  </ul>
</header>
</template>

<script>
export default {
  props:{
    disableRouter:{
      type:Boolean,
      default:false
    }
  },
  data() {
    return {
      codeImg:require('img/code.png'),
      essayImg:require('img/essay.png'),
      starImg:require('img/star.png')
    }
  }
}
</script>
<style scoped lang="scss">
@import '../scss/myvar';
#header {
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1000;
    width: 100%;

    background-color: whitesmoke;
    opacity: 0.8;
}
#header-ul {
    font-size: 0;
}
.header-li {
    display: inline-block;
    font-size: 16px;
    width: 100px;
}
.header-li-a {
    display: block;
    width: 100%;
    text-align: center;
    line-height: 50px;
    color: black;
    transition: background-color 0.3s ease;
}
.header-li-img {
    height: 30px;
    vertical-align: middle;
}
.header-li-text {
    vertical-align: middle;
}
#header-logo-li {
    position: absolute;
    left: 50%;
    margin-left: -50px;
}
.header-li:not(#header-logo-li) .header-li-a:hover {
    background-color: lightgrey;
}
@media screen and (max-width:720px) {
    .header-li {
        width: 50% !important;
    }
    #header-logo-li {
        display: none;
    }
}
</style>
