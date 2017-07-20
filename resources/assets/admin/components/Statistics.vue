<template>
<section id="chart-board">
  <button class="btn btn-default" id="back" type="submit" @click="back" v-show="state=='month'">&larr; 2017</button>
  <section id="chart"></section>
  <nav aria-label="...">
    <ul class="pager">
      <li class="previous" v-show="state=='year' ? year>2017 : month>1"><a href="#" @click="state=='year' ? year-- : month-- "><span aria-hidden="true">&larr;</span> {{state=='year' ? '上一年' : '上个月'}}</a></li>
      <li class="next"  v-show="state=='year' ? year<nowYear : month<12"><a href="#"  @click="state=='year' ? year++ : month++ ">{{state=='year' ? '下一年' : '下个月'}} <span aria-hidden="true">&rarr;</span></a></li>
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
      year: 2017,
      month: null,
      state: 'year',
      nowYear:0
    }
  },
  computed: {
    title() {
      return this.year + '年' + (this.month ? this.month + '月' : '') + '访问量统计数据';
    }
  },
  methods: {
    back(){
      this.state = 'year';
    },
    flush() {
      var url = '/stat',
        val;
      for (var i = 0, l = arguments.length; i < l; i++) {
        if (val = arguments[i]) {
          url += '/' + val;
        }
      }
      this.$http.get(url).then(response => {
        var result = response.body;
        this.year = this.nowYear = result.year;
        this.month = result.month;
        this.option.series[0].data = result.data;
        this.option.title.subtext = '共' + result.sum + '次';
        this.option.title.text = this.title;

        if (result.month) {
          this.option.xAxis.data = [];
          for (var i = 0, day = result.data.length; i < day; i++) {
            this.option.xAxis.data[i] = i+1;
          }
        }

        this.chart && this.chart.setOption(this.option);
      })
    }
  },
  created() {
    //init chart
    for (var i = 0; i < 12; i++) {
      this.option.xAxis.data[i] = (i + 1) + '月';
      this.option.series[0].data[i] = 0;
    }
    this.option.xAxis.data[i] = (i + 1) + '月';
    this.option.title.text = this.title;
    this.flush();
  },
  mounted() {
    this.chart = echarts.init(document.getElementById('chart'));

    //如果此时ajax还未返回则是对chart初始化,已返回则无任何变化
    this.chart.setOption(this.option);
    this.chart.on('click', params => {
      if(this.state=='year'){
        console.log(params);
        this.month = params.dataIndex + 1
        this.state = 'month'
      }
    })
  },
  watch: {
    year(newYear) {
      this.state == 'year' && this.flush(newYear);
    },
    month(newMonth) {
      this.state == 'month' && this.flush(this.year, newMonth);
    },
    state(newState) {
      if (newState == 'year') {
        this.option.xAxis.data = [];
        for (var i = 0; i < 12; i++) {
          this.option.xAxis.data[i]= (i + 1) + '月';
        }
        this.flush(this.year);
      } else {
        this.flush(this.year, this.month);
      }
    }
  }
}
</script>
<style scoped lang="scss">
#chart-board {
    width: 900px;
    height: 600px;
    margin: 30px auto;
}
#chart {
    width: 900px;
    height: 500px;
}
#back{
  position:absolute;
  z-index: 9999;
}
</style>
