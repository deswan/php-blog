<template>
<section id="dashboard" class="body">
  <statistics-chart></statistics-chart>
</section>
</template>
<script>
const chart = require('./Statistics');
export default {
    components:{
      'statistics-chart':chart
    }
}
</script>
<style scoped lang="scss">
</style>
