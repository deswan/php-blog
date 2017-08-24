<template>
<section id="chart-board">
  <button class="btn btn-default" id="back" type="submit" @click="back" v-show="month">&larr; 2017</button>
  <section id="chart"></section>
  <nav aria-label="...">
    <ul class="pager">
      <li class="previous" v-show="!month ? year>2017 : month>1"><a href="#" @click="!month ? year-- : month-- "><span aria-hidden="true">&larr;</span> {{!month ? '上一年' : '上个月'}}</a></li>
      <li class="next"  v-show="!month ? year<nowYear : month<12"><a href="#"  @click="!month ? year++ : month++ ">{{!month ? '下一年' : '下个月'}} <span aria-hidden="true">&rarr;</span></a></li>
    </ul>
  </nav>

</section>
</template>

<script>
//  ECharts 主模块
var echarts = require('echarts/lib/echarts');
// 柱状图
require('echarts/lib/chart/bar');
// 提示框和标题组件
require('echarts/lib/component/tooltip');
require('echarts/lib/component/title');

export default {
  props: ['articleId'],
  data() {
    return {
      chart: null,
      option: {
        title: {
          text: '',
          left: 'center',
          subtext: ''
        },
        tooltip: {
          trigger: 'axis',
          axisPointer: {
            type: 'shadow'
          }
        },
        grid: {
          left: '0%',
          bottom: '3%',
          containLabel: true
        },
        xAxis: {
          data: [],
        },
        yAxis:{

        },
        series: [{
          type: 'bar',
          data: []
        }]
      },
      year: 0,
      month: 0,
      nowYear:0
    }
  },
  computed: {
    title() {
      return this.year + '年' + (this.month ? this.month + '月' : '') + '访问量统计数据';
    }
  },
  methods: {
    back(){ //返回年
      this.month = 0;
    },
    flush() {
      var url = '/stat/getData';
      var params = {};
      this.articleId && ( url += '/' + this.articleId );
      this.year && (params.year = this.year);
      this.month && (params.month = this.month);
      this.$http.get(url,{params}).then(response => {
        var result = response.body;
        this.nowYear = result.nowYear;
        this.year = result.year;
        this.month = result.month || 0;

        //刷新轴
        this.option.xAxis.data = [];
        if (this.month) {
          for (var i = 0, day = result.data.length; i < day; i++) {
            this.option.xAxis.data[i] = i+1;
          }
        }else{
          for (var i = 0; i < 12; i++) {
            this.option.xAxis.data[i]= (i + 1) + '月';
          }
        }

        //渲染图表
        this.option.series[0].data = result.data;
        this.option.title.subtext = '共' + result.sum + '次';
        this.option.title.text = this.title;

        this.chart && this.chart.setOption(this.option);
      })
    }
  },
  created() {
    //初始化x轴
    for (var i = 0; i < 12; i++) {
      this.option.xAxis.data[i] = (i + 1) + '月';
      this.option.series[0].data[i] = 0;
    }
  },
  mounted() {
    this.chart = echarts.init(document.getElementById('chart'));
    this.flush();
    this.chart.on('click', params => {
      if(!this.month){
        this.month = params.dataIndex + 1
      }
    })
  },
  watch: {
    year(newYear,old) {
      if(!old){ return; } //初始化时year==0
      this.flush();
    },
    month(newMonth,old) {
      this.flush();
    }
  }
}
</script>
<style scoped lang="scss">
#chart-board {
    width: 900px;
    height: 600px;
    margin: 0 auto;
}
#chart {
    height: 100%;
}
#back{
  position:absolute;
  z-index: 9999;
}
</style>
