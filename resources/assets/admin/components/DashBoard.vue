<template>
<section id="chart-board" class="body">
  <button class="btn btn-default" type="submit">&larr; 2017</button>
  <section id="chart">

  </section>
  <nav aria-label="...">
    <ul class="pager">
      <li class="previous"><a href="#"><span aria-hidden="true">&larr;</span> Older</a></li>
      <li class="next"><a href="#">Newer <span aria-hidden="true">&rarr;</span></a></li>
    </ul>
  </nav>

</section>
</template>

<script>
// 引入 ECharts 主模块
var echarts = require('echarts/lib/echarts');
// 引入柱状图
require('echarts/lib/chart/bar');
// 引入提示框和标题组件
require('echarts/lib/component/tooltip');
require('echarts/lib/component/title');
export default {
  data() {
    return {}
  },
  mounted(){
    var myChart = echarts.init(document.getElementById('chart'));
    // 指定图表的配置项和数据
    var option = {
        title: {
            text: '2017年访问量统计数据',
            left:'center',
            subtext: '单位：次'
        },
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'shadow'
            }
        },
        grid: {
            left: '0%',
            right: '4%',
            bottom: '3%',
            containLabel: true
        },
        xAxis: {
            data: ['1月','1月','1月','1月','1月','1月','1月','1月','1月','1月','1月'],
        },
        yAxis: {
        },
        series: [{
            type: 'bar',
            data: [5, 20, 36, 10, 10, 20]
        }]
    };
    // 使用刚指定的配置项和数据显示图表。
    myChart.setOption(option);
  }
}
</script>
<style scoped lang="scss">
#chart-board{
  width: 900px;
  height: 600px;
  margin:30px auto;
}
#chart{
  width: 900px;
  height: 500px;
}
</style>
