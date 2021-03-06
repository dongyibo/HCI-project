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
    @include('common.data')
@stop


@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('static/css/auxiliary.css')}}" />
    <script src="{{asset('static/js/avatarHandle.js')}}"></script>
    <script src="{{asset('static/js/data.js')}}"></script>
@stop

@section('javascript')
    <script src="{{asset('static/js/data.js')}}"></script>
    <script src="{{asset('static/js/avatarHandle.js')}}"></script>
@stop