$(document).ready(function () {

    initChart(window.activityId);

});

function initChart(id) {
    var success = function (data) {
        var charts = echarts.init(document.getElementById('self_charts'));
        var datax = [];
        var datay = [];
        // var count = 0;
        var sum = 0;
        for (var i in data) {
            datax.push(data[i].username);
            datay.push(data[i].dis);
            sum += data[i].dis;
        }
        var prompt = "";
        if (sum > 8000000){
            prompt="这只队伍活力十足！"
        }
        else if(prompt > 6000000){
            prompt="充满朝气的团队！"
        }
        else if(prompt > 4000000){
            prompt="生命在于运动，前进吧！"
        }
        else if (prompt > 2000000){
            prompt="加油吧！燃烧者们！"
        }
        else{
            prompt="无所畏惧的运动健儿~"
        }
        var color = 'green';

        var title = "活动参与用户运动距离比较";
        if (sum ==0){
            title="这个团队还没有运动记录哦~";
            prompt="请加强锻炼！";
            color= 'red';
        }

            option = {
                title: {
                    x: 'center',
                    text: title,
                    textStyle: {fontSize: 22},
                    subtext: prompt,
                    subtextStyle: {fontSize: 16,color: color}
                },
                tooltip: {
                    trigger: 'item'
                },
                calculable: true,
                grid: {
                    borderWidth: 0,
                    y: 80,
                    y2: 60
                },
                xAxis: [
                    {
                        type: 'category',
                        show: false,
                        data: datax
                    }
                ],
                yAxis: [
                    {
                        type: 'value',
                        show: false,
                        // name: '距离/米'
                    }
                ],
                series: [
                    {
                        name: '运动距离/米',
                        type: 'bar',
                        itemStyle: {
                            normal: {
                                color: function (params) {
                                    // build a color map as your need.
                                    var colorList = [
                                        '#C1232B', '#B5C334', '#FCCE10', '#E87C25', '#27727B',
                                        '#FE8463', '#9BCA63', '#FAD860', '#F3A43B', '#60C0DD',
                                        '#D7504B', '#C6E579', '#F4E001', '#F0805A', '#26C0C0'
                                    ];
                                    return colorList[params.dataIndex]
                                },
                                label: {
                                    show: true,
                                    position: 'top',
                                    formatter: '{b}\n{c}'
                                }
                            }
                        },
                        data: datay,
                        markPoint: {
                            tooltip: {
                                trigger: 'item',
                                backgroundColor: 'rgba(0,0,0,0)',
                                formatter: function (params) {
                                    return '<img src="'
                                        + params.data.symbol.replace('image://', '')
                                        + '"/>';
                                }
                            },
                            data: [
                                {
                                    xAxis: 0,
                                    y: 350,
                                    name: 'Line',
                                    symbolSize: 20,
                                    symbol: 'image://../asset/ico/折线图.png'
                                },
                                {xAxis: 1, y: 350, name: 'Bar', symbolSize: 20, symbol: 'image://../asset/ico/柱状图.png'},
                                {
                                    xAxis: 2,
                                    y: 350,
                                    name: 'Scatter',
                                    symbolSize: 20,
                                    symbol: 'image://../asset/ico/散点图.png'
                                },
                                {xAxis: 3, y: 350, name: 'K', symbolSize: 20, symbol: 'image://../asset/ico/K线图.png'},
                                {xAxis: 4, y: 350, name: 'Pie', symbolSize: 20, symbol: 'image://../asset/ico/饼状图.png'},
                                {
                                    xAxis: 5,
                                    y: 350,
                                    name: 'Radar',
                                    symbolSize: 20,
                                    symbol: 'image://../asset/ico/雷达图.png'
                                },
                                {
                                    xAxis: 6,
                                    y: 350,
                                    name: 'Chord',
                                    symbolSize: 20,
                                    symbol: 'image://../asset/ico/和弦图.png'
                                },
                                {
                                    xAxis: 7,
                                    y: 350,
                                    name: 'Force',
                                    symbolSize: 20,
                                    symbol: 'image://../asset/ico/力导向图.png'
                                },
                                {xAxis: 8, y: 350, name: 'Map', symbolSize: 20, symbol: 'image://../asset/ico/地图.png'},
                                {
                                    xAxis: 9,
                                    y: 350,
                                    name: 'Gauge',
                                    symbolSize: 20,
                                    symbol: 'image://../asset/ico/仪表盘.png'
                                },
                                {
                                    xAxis: 10,
                                    y: 350,
                                    name: 'Funnel',
                                    symbolSize: 20,
                                    symbol: 'image://../asset/ico/漏斗图.png'
                                },
                            ]
                        }
                    }
                ]
            };
        charts.setOption(option);
    };
    $.ajax({
        type: 'GET',
        url: '/relax/public/ajax/compareActivity/' + id,
        dataType: 'json',
        success: success,
        error: function (xhr, type) {
            alert(xhr.status);
            alert(xhr.readyState);
            alert(type);
        }
    });

}
