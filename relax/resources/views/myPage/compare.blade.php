@extends('common.templet')

@section('nav')
    @include('common.navigation')
@stop



@section('content')
    <script type="text/javascript">
        window.compareId={{$user->id}};
    </script>
    <div class="row">
        <div class="col-lg-12 text-center">
            <h2>数据排名</h2>
            <hr class="star-primary">
        </div>
    </div>

    <div class="row" style="margin-top: 50px">
        <div class="col-lg-12">
            <div class="col-lg-12" id="self_chart2"></div>
        </div>
    </div>

    <div class="row" style="margin-top: 50px">
        <div class="col-lg-12">
            <div class="col-lg-12" id="self_chart"></div>
        </div>
    </div>


@stop


@section('css')
    <link href="{{asset('static/css/auxiliary.css')}}" rel="stylesheet">
    <link href="{{asset('static/css/compare.css')}}" rel="stylesheet">
    <script src="{{asset('static/js/avatarHandle.js')}}"></script>
    <script src="{{asset('static/js/compare.js')}}"></script>


@stop

@section('javascript')
    <script src="{{asset('static/js/avatarHandle.js')}}"></script>
    <script src="{{asset('static/js/compare.js')}}"></script>
@stop