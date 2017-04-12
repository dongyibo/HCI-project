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
    @include('common.hotUsers')
@stop