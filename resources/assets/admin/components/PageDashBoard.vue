<template>
<section id="dashboard">
  <div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">总访问量统计</h3>
  </div>
  <div class="panel-body">
    <statistic></statistic>
  </div>
</div>

</section>
</template>
<script>
const statistic = require('./Statistics');
export default {
    components:{
      statistic
    }
}
</script>
<style scoped lang="scss">
@import "../scss/var";
#dashboard{
  @include content-box;
  margin:30px 0;
}
</style>
