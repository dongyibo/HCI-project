@extends('common.templet')

@section('nav')
    @include('common.navigation')
@stop

@section('logout')
    <a href="{{url('home/userLogout')}}">
        <img onmouseover="logoutIn(this);" onmouseout="logoutOut(this);" title="注销" src="{{asset('static/images/admin/nav/logout.png')}}" />
    </a>
@stop

@section('content')
    <script type="text/javascript">
        window.dataId={{$user->id}};
    </script>
    <div class="row">
        <div class="col-lg-12 text-center">
            <h2>历史数据</h2>
            <hr class="star-primary">
        </div>
    </div>

    <div class="row" style="margin-top:50px;">
        <div class="col-lg-1 col-lg-offset-1">
            <img src="{{asset('static/images/my/statistic/chart.png')}}"/>
        </div>
        <div class="col-lg-3 sex_title_div">
            <h4>个人运动距离统计</h4>
        </div>
        <div class="col-lg-1 col-lg-offset-4" style="width: 10%">
            <select id="year_data" class="form-control" onchange="initDistance({{$user->id}});">
                <option>2016</option>
                <option selected="selected">2017</option>
            </select>
        </div>
        <div class="col-lg-1 time_detail" style="width:10%">年</div>
        <div class="col-lg-1 month_div" style="width: 11%">
            <select id="month_data" class="form-control" onchange="initDistance({{$user->id}});">
                <option>显示全年</option>
                @for($i=1;$i<=12;$i++)
                <option>{{$i}}</option>
                @endfor
            </select>
        </div>
        <div class="col-lg-1 time_detail" style="width:10%">月</div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="col-lg-12" id="self_chart"></div>
        </div>
    </div>

    <HR class="HR" style="FILTER: progid:DXImageTransform.Microsoft.Glow(color=#987cb9,strength=10)" width="100%" color=#987cb9 SIZE=1>


    <div class="row">
        <div class="col-lg-1 col-lg-offset-1">
            <img src="{{asset('static/images/my/statistic/sex.png')}}"/>
        </div>
        <div class="col-lg-4 sex_title_div">
            <h4>社区用户统计</h4>
        </div>
    </div>
    <div class="row" style="margin-top: 40px">
        <div class="col-lg-12">
            <div class="col-lg-6" id="sex_chart"></div>
            <div class="col-lg-6" id="level_chart"></div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('static/css/auxiliary.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('static/css/statistic.css')}}" />
    <script src="{{asset('static/js/avatarHandle.js')}}"></script>
@stop

@section('javascript')
    <script src="{{asset('static/js/statistic.js')}}"></script>
    <script src="{{asset('static/js/avatarHandle.js')}}"></script>
@stop