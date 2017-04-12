$(document).ready(function () {
    initChart(window.compareId);
    initChart2(window.compareId);

});

function initChart(id) {
    var success = function (data) {
        var chart = echarts.init(document.getElementById('self_chart'));
        var datax = [];
        var datay = [];
        var count = 0;
        for(var i in data){
            datax.push(data[i].username);
            datay.push(data[i].dis);
            if (id == data[i].id){
                count = parseInt(i)+1;
            }
        }
        //
        // alert(parseInt(count));
        option = {
            title: {
                x: 'center',
                text: '运动距离排名',
                textStyle:
                    {fontSize: 22},
                subtext: '您是第'+parseInt(count)+'名',
                subtextStyle:
                    {fontSize: 16}
                // link: 'http://echarts.baidu.com/doc/example.html'
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
                            {xAxis: 0, y: 350, name: 'Line', symbolSize: 20, symbol: 'image://../asset/ico/折线图.png'},
                            {xAxis: 1, y: 350, name: 'Bar', symbolSize: 20, symbol: 'image://../asset/ico/柱状图.png'},
                            {xAxis: 2, y: 350, name: 'Scatter', symbolSize: 20, symbol: 'image://../asset/ico/散点图.png'},
                            {xAxis: 3, y: 350, name: 'K', symbolSize: 20, symbol: 'image://../asset/ico/K线图.png'},
                            {xAxis: 4, y: 350, name: 'Pie', symbolSize: 20, symbol: 'image://../asset/ico/饼状图.png'},
                            {xAxis: 5, y: 350, name: 'Radar', symbolSize: 20, symbol: 'image://../asset/ico/雷达图.png'},
                            {xAxis: 6, y: 350, name: 'Chord', symbolSize: 20, symbol: 'image://../asset/ico/和弦图.png'},
                            {xAxis: 7, y: 350, name: 'Force', symbolSize: 20, symbol: 'image://../asset/ico/力导向图.png'},
                            {xAxis: 8, y: 350, name: 'Map', symbolSize: 20, symbol: 'image://../asset/ico/地图.png'},
                            {xAxis: 9, y: 350, name: 'Gauge', symbolSize: 20, symbol: 'image://../asset/ico/仪表盘.png'},
                            {xAxis: 10, y: 350, name: 'Funnel', symbolSize: 20, symbol: 'image://../asset/ico/漏斗图.png'},
                        ]
                    }
                }
            ]
        };
        chart.setOption(option);
    };
    $.ajax({
        type: 'GET',
        url: '/relax/public/ajax/compareDetail/' + id,
        dataType: 'json',
        success: success,
        error: function (xhr, type) {
            alert(xhr.status);
            alert(xhr.readyState);
            alert(type);
        }
    });
}



function initChart2(id) {
    var success = function (data) {
        var chart = echarts.init(document.getElementById('self_chart2'));
        var datax = [];
        var datay = [];
        var count = 0;
        for(var i in data){
            datax.push(data[i].username);
            datay.push(data[i].activity);
            if (id == data[i].id){
                count = parseInt(i)+1;
            }
        }
        //
        // alert(datay);
        option = {
            title: {
                x: 'center',
                text: '活力度排名',
                textStyle:
                    {fontSize: 22},
                subtext: '您是第'+parseInt(count)+'名',
                subtextStyle:
                    {fontSize: 16}
                // link: 'http://echarts.baidu.com/doc/example.html'
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
                    name: '活跃度',
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
                            {xAxis: 0, y: 350, name: 'Line', symbolSize: 20, symbol: 'image://../asset/ico/折线图.png'},
                            {xAxis: 1, y: 350, name: 'Bar', symbolSize: 20, symbol: 'image://../asset/ico/柱状图.png'},
                            {xAxis: 2, y: 350, name: 'Scatter', symbolSize: 20, symbol: 'image://../asset/ico/散点图.png'},
                            {xAxis: 3, y: 350, name: 'K', symbolSize: 20, symbol: 'image://../asset/ico/K线图.png'},
                            {xAxis: 4, y: 350, name: 'Pie', symbolSize: 20, symbol: 'image://../asset/ico/饼状图.png'},
                            {xAxis: 5, y: 350, name: 'Radar', symbolSize: 20, symbol: 'image://../asset/ico/雷达图.png'},
                            {xAxis: 6, y: 350, name: 'Chord', symbolSize: 20, symbol: 'image://../asset/ico/和弦图.png'},
                            {xAxis: 7, y: 350, name: 'Force', symbolSize: 20, symbol: 'image://../asset/ico/力导向图.png'},
                            {xAxis: 8, y: 350, name: 'Map', symbolSize: 20, symbol: 'image://../asset/ico/地图.png'},
                            {xAxis: 9, y: 350, name: 'Gauge', symbolSize: 20, symbol: 'image://../asset/ico/仪表盘.png'},
                            {xAxis: 10, y: 350, name: 'Funnel', symbolSize: 20, symbol: 'image://../asset/ico/漏斗图.png'},
                        ]
                    }
                }
            ]
        };
        chart.setOption(option);
    };
    $.ajax({
        type: 'GET',
        url: '/relax/public/ajax/compareLevel/' + id,
        dataType: 'json',
        success: success,
        error: function (xhr, type) {
            alert(xhr.status);
            alert(xhr.readyState);
            alert(type);
        }
    });
}
