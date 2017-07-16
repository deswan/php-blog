<template>
<section id="banner">
  <div class="effect"></div>
  <div class="effect"></div>
  <div class="effect"></div>

  <h1 id="banner-text">STEPHANIE<br>WALK IN STREET</h1>
</section>
</template>

<script>
export default {
}
</script>
<style scoped lang="scss">
#banner {
    display: block;
    width: 400px;
    height: 220px;
    margin: 100px auto;
    text-align: center;

    .effect {
        position: absolute;
        height: 80px;
        width: 100px;
        background-color: rgba(255,255,255,0.8);
        box-shadow: inset 0 0 30px 5px #e0e0e0;
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
}
#banner-text{
  font-size: 4em;
}
</style>
