<template>
    <canvas id="chart" width="90%" height="95%"></canvas>
</template>

<script>
    var addEvent = function (element, name, handler) {
        if (element.addEventListener) {
            addEvent = function (element, name, handler) {
                element.addEventListener(name, handler, false);
            }
        }
        else if (element.attachEvent) {
            addEvent = function (element, name, handler) {
                element.attachEvent('on' + name, handler);
            }
        }else{
            addEvent = function (element, name, handler) {
                element['on' + name] = handler;
            }
        }
        addEvent(element, name, handler);
    }
    var removeEvent = function (element, name, handler) {
        if (element.removeEventListener) {
            removeEvent = function (element, name, handler) {
                element.removeEventListener(name, handler, false);
            }
        }else if (element.removeEvent) {
            removeEvent = function (element, name, handler) {
                element.removeEvent('on' + name, handler);
            }
        }else{
            removeEvent = function (element, name) {
                element['on' + name] = null;
            }
        }
        removeEvent(element, name, handler);
    }
    export default {
        data(){
            return {

            }
        },
        methods:{
            toFloor(num){
                var s = num.toString();
                return parseInt(s.substr(0,s.length-2)+'00')+100;
            },
            draw(chart,dataX,dataY,size){
                var data_max = Math.max.apply(null,dataY);
                var floor = this.toFloor(data_max)
                var data_grow = floor/5;
                var ct = chart.getContext('2d');

                ct.textBaseline='top';
                ct.textAlign='center';

                //resize canvas
                var li = document.defaultView.getComputedStyle(document.getElementsByClassName('chart-li')[0])
                var w = parseInt(li.width) - parseInt(li.paddingLeft) - parseInt(li.paddingRight);
                var h = parseInt(li.height) - parseInt(li.paddingTop) - parseInt(li.paddingBottom);
                chart.setAttribute('width', w + 'px');
                chart.setAttribute('height', h + 'px');

                ct.strokeStyle = 'gray';
                ct.font = 'normal 16px "Microsoft Yahei"';
                var grid_o ={x:50,y:9*chart.height/10}
                var grid_width = 9*chart.width/10-grid_o.x;
                var grid_height = grid_o.y-0.5*chart.height/10;
                ct.beginPath();
                ct.moveTo(grid_o.x, grid_o.y);
                ct.lineTo(grid_o.x+grid_width, grid_o.y)
                ct.moveTo(grid_o.x, grid_o.y);
                ct.lineTo(grid_o.x, grid_o.y-grid_height)
                ct.stroke()
                var intervalX = grid_width*0.95/(dataX.length-1);
                var intervalY = grid_height*0.95/5
                for(var i=0;i<dataX.length;i++){
                    ct.fillStyle = 'gray';
                    ct.textBaseline='top';
                    ct.textAlign='center';
                    ct.fillText(dataX[i],grid_o.x+intervalX*i,grid_o.y)
                    ct.textBaseline='middle';
                    ct.textAlign='end';
                    if(i<=5) {  //Y轴标示绘制
                        ct.fillText(Math.floor(data_grow * i), grid_o.x-10, grid_o.y - intervalY * i-10)
                        ct.beginPath()
                        ct.moveTo(grid_o.x,grid_o.y - intervalY * i-10)
                        ct.lineTo(grid_o.x+grid_width,grid_o.y - intervalY * i-10)
                        ct.stroke();
                    }
                }
                ct.fillStyle = '#26a69a';
                for(i=0;i<dataY.length;i++){
                    ct.textBaseline='bottom';
                    ct.textAlign='center';
                    ct.fillText(dataY[i],grid_o.x+intervalX*i+intervalX/2,grid_o.y-(dataY[i]/floor*grid_height*0.95)-10)
                    ct.fillRect(grid_o.x+intervalX*i+intervalX*(1-size),
                            grid_o.y-(dataY[i]/floor*grid_height*0.95)-10,
                            intervalX*(2*size-1),
                            dataY[i]/floor*grid_height*0.95+10)
                }
            }
        },
        mounted(){
            //ajax获取数据
            var chart = document.getElementById('chart');

            var dataX = [12,1,2,3,4,5,6,7,8,9,10,11,12];    //13
            var dataY = [0,1245,213,654,124,677,945,741,841,517,190,498]  //12
            var size = 0.8;
            this.draw(chart,dataX,dataY,size);
            addEvent(window,'resize',() => this.draw(chart,dataX,dataY,size));
        }
    }
</script>
<style>

</style>
