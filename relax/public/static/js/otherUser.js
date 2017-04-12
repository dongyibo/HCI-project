$(document).ready(function() {
   //初始化用户一周活动表格
    initUserChart();
});

/**
 * 初始化用户一周活动表格
 */
function initUserChart(){
    var pathName=location.pathname;
    var split=pathName.split("/");
    var id=split[split.length-1];
    var success=function (data) {
        var myChart=echarts.init(document.getElementById('user_chart'));
        var date = [];
        var re = [];
        for(var i=data.length-1;i>=0;i--){
            date.push(data[i].date);
            re.push(data[i].dist);
        }

        option = {
            tooltip: {
                trigger: 'axis',
                position: function (pt) {
                    return [pt[0], '10%'];
                }
            },
            title: {
                left: 'center',
                text: '最近七天运动距离'
            },
            xAxis: {
                type: 'category',
                boundaryGap: false,
                data: date,
                name : '日期'
            },
            yAxis: {
                type: 'value',
                boundaryGap: [0, '100%'],
                name : '距离/米'
                // font: '14px'
            },
            series: [
                {
                    name:'距离',
                    type:'line',
                    smooth:true,
                    symbol: 'none',
                    sampling: 'average',
                    itemStyle: {
                        normal: {
                            color: 'rgb(255, 70, 131)'
                        }
                    },
                    areaStyle: {
                        normal: {
                            color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                                offset: 0,
                                color: 'rgb(255, 158, 68)'
                            }, {
                                offset: 1,
                                color: 'rgb(255, 70, 131)'
                            }])
                        }
                    },
                    data: re
                }
            ]
        };
        // 使用刚指定的配置项和数据显示图表。
        myChart.setOption(option);
    }
    $.ajax({
        type: 'GET',
        url: '/relax/public/ajax/userRecentDay/'+id,
        dataType: 'json',
        success: success,
        error: function (xhr, type) {
            alert(xhr.status);
            alert(xhr.readyState);
            alert(type);
        }
    });

}

/**
 * 关注用户
 */
function forkUser(myId,forkId) {
    //alert(myId+" "+forkId);
    var success=function (data) {
        if(data.msg=='关注成功!'){
            $('#friend_alert').removeClass('alert-warning');
            $('#friend_alert').addClass('alert-success');
            $('#fork_btn').hide();
        }
        else{
            $('#friend_alert').removeClass('alert-success');
            $('#friend_alert').addClass('alert-warning');
        }
        $('#friend_alert').show();
        $('#friend_alert').text(data.msg);
        $('#friend_alert').fadeOut(2000);
        window.location="/relax/public/my/friend";
    };
    $.ajax({
        type: 'POST',
        url: '/relax/public/ajax/fork',
        data: {
            'userId' : myId,
            'friendId':forkId
        },
        dataType: 'json',
        success: success,
        error: function(xhr, type){
            alert('Ajax error!')
        }
    });
}