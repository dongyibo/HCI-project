<div class="row">
    <div class="col-lg-12 text-center">
        <h2>热门用户Top 6</h2>
        <hr class="star-primary">
    </div>
</div>

<div id="hotUser_alert_div" class="row">
    <div class="col-lg-8 col-lg-offset-2">
        <div id="hotUser_alert" class="alert alert-success" style="display: none;">
        </div>
    </div>
</div>

<div class="row">
    @foreach($users as $u)
    <div class="col-lg-4 content-item">
        <div class="row">
            <div class="col-lg-12 col-lg-offset-2">
                <a href="{{url('user/'.$u->id)}}" class="content-link" data-
                   toggle="modal">
                    <div class="caption">
                        <div class="caption-content">
                            <i class="fa fa-hand-o-right fa-3x"></i>
                        </div>
                    </div>
                    <div>
                        <img class="img-rounded avatar_hot_size" src="{{$u->portrait?asset('uploads/avatar/'.$u->portrait):asset('static/images/my/temp.png')}}">
                    </div>
                </a>
            </div>
            <div class="col-lg-12 col-lg-offset-2">
                <div class="row">
                    <div class="col-lg-12">
                        <span class="username_span">{{$u->username}}</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3" style="margin-right: -30px;padding-top: 2px">
                        <img src="{{asset('static/images/my/hot/activity.png')}}">
                        <span style="font-size:11px;color: #8a8a8a;">活跃度</span>
                    </div>
                    <div class="col-lg-6 activity_div">
                        <h4 class="activity_color">{{$u->activity}}</h4>
                    </div>
                    <div class="col-lg-1 fork_icon_div">
                        <a href="javascript:forkHotUser({{$user->id}},{{$u->id}});"><img onmouseout="forkOut(this)" onmouseover="forkIn(this);" class="fork_icon" src="{{asset('static/images/my/hot/fork.png')}}"></a>
                    </div>
                </div>
            </div>
        </div>
        {{--<div class="col-lg-4" style="height:30px"><span>刘嘉</span></div>--}}
    </div>
    @endforeach

</div>

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('static/css/auxiliary.css')}}" />
    <script src="{{asset('static/js/avatarHandle.js')}}"></script>
    <script src="{{asset('static/js/fork.js')}}"></script>
@stop

@section('javascript')
    <script src="{{asset('static/js/avatarHandle.js')}}"></script>
@stop