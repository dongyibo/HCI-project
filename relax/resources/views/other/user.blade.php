@extends('common.templet')

@section('nav')
    <div id="fh5co-header" role="banner">
        <div class="container">
            <div class="row">
                <div class="header-inner">
                    <h1><a>RELAX<span>.</span></a></h1>
                    <nav role="navigation">
                    </nav>
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12 text-center">
            <h2>用户资料</h2>
            <hr class="star-primary">
        </div>
    </div>

    <div id="friend_alert_div" class="row">
        <div class="col-lg-8 col-lg-offset-2">
            <div id="friend_alert" class="alert alert-success" style="display: none;">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">用户信息</h3>
                </div>
                <div class="panel-body">
                    {{--插入表单--}}
                    @if(!$isFriend)
                    <div class="row" id="fork_btn">
                        <div class="col-lg-1" style="margin-left: 44%">
                            <button onclick="forkUser({{$realId}},{{$other->id}})" type="button" class="btn btn-info">关注该用户</button>
                        </div>
                    </div>
                    @endif
                    <br>
                    <div class="row">
                        <div class="col-lg-10 col-lg-offset-2" id="info_div">
                            <form class="form-horizontal" method="post" action="">{{--{{url('User/save')}}--}}

                                {{csrf_field()}} {{-- 生成一个隐藏的表单，生成一个token字段 --}}

                                <div class="form-group">
                                    <label for="username" class="col-lg-2 control-label">用户名</label>

                                    <div class="col-lg-5">
                                        <input readonly="true" value="{{$other->username}}" type="text"
                                               name="User[username]" class="form-control input_data" id="username"
                                               placeholder="请输入您的用户名">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email" class="col-lg-2 control-label">电子邮箱</label>

                                    <div class="col-lg-5">
                                        <input readonly="readonly" value='{{$other->email}}' type="text"
                                               name="User[email]" class="form-control input_data" id="email"
                                               placeholder="请输入您的电子邮箱">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="age" class="col-lg-2 control-label">年龄</label>

                                    <div class="col-lg-5">
                                        <input value="{{$other->age}}" readonly="readonly" type="text" name="User[age]"
                                               class="form-control input_data" id="age" placeholder="请输入您的年龄">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-2 control-label">性别</label>

                                    <div class="col-lg-5">
                                        <input value="{{$other->sex}}" readonly="readonly" type="text" name="User[sex]"
                                               class="form-control input_data" id="sex" placeholder="请输入您的年龄">
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label for="height" class="col-lg-2 control-label">身高</label>

                                    <div class="col-lg-5">
                                        <input value="{{$other->height}}" readonly="readonly" type="text"
                                               name="User[height]" class="form-control input_data" id="height"
                                               placeholder="请输入您的身高（cm）">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="weight" class="col-lg-2 control-label">体重</label>

                                    <div class="col-lg-5">
                                        <input value="{{$other->weight}}" readonly="readonly" type="text"
                                               name="User[weight]" class="form-control input_data" id="weight"
                                               placeholder="请输入您的体重（kg）">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 user_chart_div">
                            <div id="user_chart">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link href="{{asset('static/css/user.css')}}" rel="stylesheet">
    <script src="{{asset('static/js/otherUser.js')}}"></script>
@stop

@section('javascript')
    <script src="{{asset('static/js/otherUser.js')}}"></script>
{{--    <script src="{{asset('static/js/friend.js')}}"></script>--}}
@stop