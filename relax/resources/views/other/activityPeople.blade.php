<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Relax - Your Sports Community</title>
    <link rel="shortcut icon" href="{{asset('static/images/walk.png')}}">
    <link href="{{asset('static/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('static/css/my.css')}}" rel="stylesheet">
    <link href="{{asset('static/css/auxiliary.css')}}" rel="stylesheet">
    <link href="{{asset('static/css/friend.css')}}" rel="stylesheet">
    <link href="{{asset('static/css/userOpreation.css')}}" rel="stylesheet">
    <link href="{{asset('static/css/template.css')}}" rel="stylesheet">
    <link href="{{asset('static/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">
@section('css')
@show
<!-- 部分需要提前的js文件 -->
    {{--<script src="{{asset('static/js/eventHandler.js')}}"></script>--}}
    <script src="{{asset('static/jquery/jquery.form.js')}}"></script>
    <script src="{{asset('static/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('static/js/activityCompare.js')}}"></script>
    {{--<script src="{{asset('static/js/my.js')}}"></script>--}}
</head>

<body id="page-top" class="index">
{{--    {{Request::getPathInfo()}}--}}
{{--@if(Request::getPathInfo()!="/user/$user->id")--}}
{{--@endif--}}
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

<header id="head">
    <div class="container">
        <div class="row">

        </div>
    </div>
</header>
<!-- content Grid Section -->
<script type="text/javascript">
    window.activityId ={{$activityId}};
</script>


<section id="content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2>活动参与用户</h2>
                <hr class="star-primary">
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 user_list_div">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">用户列表</h3>
                    </div>
                    <div class="panel-body">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-lg-1">
                                        <a href="{{url('user/'.$sponsor->id)}}"><img class="friend_list_avatar"
                                                                                     src="{{$sponsor->portrait?asset('uploads/avatar/'.$sponsor->portrait):asset('static/images/my/temp.png')}}"/></a>
                                    </div>
                                    <div class="col-lg-9 user_name_div">
                                        <span class="name_h4">{{$sponsor->username}}</span>
                                        <img style="padding-left: 5px"
                                             src="{{$sponsor->sex=='男'?asset('static/images/admin/user/man.png'):asset('static/images/admin/user/woman.png')}}"/>
                                        <img style="padding-left: 5px"
                                             src="{{asset('static/images/my/activity/sponsor.svg')}}"/>
                                    </div>
                                    <div class="col-lg-1 col-lg-offset-1 detail_icon_div">
                                        <a href="{{url('user/'.$sponsor->id)}}"><img title="用户资料"
                                                                                     class="friend_list_icon"
                                                                                     src="{{asset('static/images/my/friend/detail.svg')}}"></a>
                                    </div>
                                </div>
                            </li>
                            @foreach($users as $u)
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-lg-1">
                                            <a href="{{url('user/'.$u->id)}}"><img class="friend_list_avatar"
                                                                                   src="{{$u->portrait?asset('uploads/avatar/'.$u->portrait):asset('static/images/my/temp.png')}}"/></a>
                                        </div>
                                        <div class="col-lg-9 user_name_div">
                                            <span class="name_h4">{{$u->username}}</span><img style="padding-left: 5px"
                                                                                              src="{{$u->sex=='男'?asset('static/images/admin/user/man.png'):asset('static/images/admin/user/woman.png')}}"/>
                                        </div>
                                        <div class="col-lg-1 col-lg-offset-1 detail_icon_div">
                                            <a href="{{url('user/'.$u->id)}}"><img title="用户资料" class="friend_list_icon"
                                                                                   src="{{asset('static/images/my/friend/detail.svg')}}"></a>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>


        <div class="row" style="margin-top: 50px">
            <div class="col-lg-12">
                <div class="col-lg-12" id="self_charts">
                </div>
            </div>
        </div>


    </div>
</section>
<!-- Footer -->
<footer class="text-center">
    <div class="footer-below">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    Copyright &copy; Relax 2016.
                </div>
            </div>
        </div>
    </div>
</footer>
<script src="{{asset('static/js/echarts.min.js')}}"></script>
<script src="{{asset('static/jquery/jquery.min.js')}}"></script>
<script src="{{asset('static/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('static/js/my.js')}}"></script>
<script src="{{asset('static/jquery/jquery.form.js')}}"></script>
<script src="{{asset('static/js/activityCompare.js')}}"></script>

</body>
</html>