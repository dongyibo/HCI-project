<div id="activities_alert_div" class="row" style="margin-top: 20px;">
    <div class="col-lg-12">
        <div id="activities_alert" class="alert alert-success" style="display: none;">
        </div>
    </div>
</div>

<div class="row">
    <div class="panel-default" style="border: 0 solid transparent;background-color: #FDF9F4">
        <div class="row">
            <div class="content-title" style="padding-left: 15px">
                <span>活动列表</span>
            </div>
        </div>
        <div class="panel-body">
            <div class="row">
                @for($i=0;$i<3;$i++)
                    @if($i<count($activities))
                        <div class="col-lg-4 content-item">
                            <div class="row">
                                <div class="col-lg-10 col-lg-offset-1">
                                    <a href="javascript:void(0)" class="more_detail content-link" data-
                                       toggle="modal">
                                        <div class="caption">
                                            <div class="caption-content">
                                                <i class="fa fa-hand-o-right fa-3x"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <img class="event_img img-rounded"
                                                 src="{{asset('uploads/activity/'.$activities[$i]->picture)}}">
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-10 col-lg-offset-1">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <h4>{{$activities[$i]->name}}</h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-1">
                                            <img src="{{asset('static/images/my/activity/address.png')}}">
                                        </div>
                                        <div class="col-lg-10 address_div">
                                            <span class="activity_address">{{$activities[$i]->address}}</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-1">
                                            <img src="{{asset('static/images/my/activity/time.png')}}">
                                        </div>
                                        <div class="col-lg-10 time_div">
                                            <span class="activity_time">{{date('Y-m-d H:i:s',$activities[$i]->time)}}</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-1">
                                            <img src="{{asset('static/images/my/activity/sponsor1.svg')}}">
                                        </div>
                                        <div class="col-lg-10 time_div">
                                            <span class="activity_time"><a class="activity_sponsor_link"
                                                                           href="{{url('user/'.$activities[$i]->sponsorId)}}">{{$sponsors[$i]}}</a></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <a class="activity_people_link"
                                           href="{{url('my/showActivityPeople/'.$activities[$i]->id)}}">
                                            <div class="col-lg-4">
                                                <h5>已报名：</h5>
                                            </div>
                                            <div class="col-lg-6 people_num_div">
                                                <h4 class="h4_num">{{$activities[$i]->peopleSign}}</h4><span
                                                        class="sprit"> /</span><h4 class="h4_num">
                                                    &nbsp;{{$activities[$i]->peopleLimit}}</h4>
                                                {{--<span class="subhead-titie">查看</span>--}}
                                            </div>
                                        </a>
                                        <div class="col-lg-2 col-lg-offset-1">
                                            @if(!$user->isAdmin)
                                                @if($user->id!=$activities[$i]->sponsorId)
                                                    @if($activities[$i]->time < time())
                                                        <img width="53" height="34"
                                                             src="{{asset('static/images/my/activity/timeout.png')}}">
                                                    @elseif($activities[$i]->peopleSign == $activities[$i]->peopleLimit && $attend[$i]!=1)
                                                        <img width="53" height="34"
                                                             src="{{asset('static/images/my/activity/full.png')}}">
                                                    @else
                                                        <button onclick="joinActivity(this,{{$user->id}},{{$activities[$i]->id}},{{$activities[$i]->time}});"
                                                                type="button"
                                                                class="{{$attend[$i]==1?'btn-warning':'btn-primary'}} join_btn btn">{{$attend[$i]==1?'取消参与':'参与'}}</button>
                                                    @endif
                                                @else
                                                    <button onclick="deleteActivity({{$activities[$i]->id}},{{$activities[$i]->time}});"
                                                            type="button" class="off_btn btn btn-primary">下台
                                                    </button>
                                                @endif
                                            @else
                                                <button onclick="deleteActivity({{$activities[$i]->id}},{{$activities[$i]->time}});"
                                                        type="button" class="off_btn btn btn-primary">下台
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 content-item event_detail_div">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        详情
                                    </h3>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-12 event_detail_content">{{$activities[$i]->detail}}</div>
                                        <div class="col-lg-1 col-lg-offset-10">
                                            <a class="back_to_introduction" href="javascript:void(0)"><img
                                                        class="back_icon"
                                                        src="{{asset('static/images/my/activity/back.png')}}"></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endfor
            </div>

            <div class="row">
                @for($i=3;$i<6;$i++)
                    @if($i<count($activities))
                        <div class="col-lg-4 content-item">
                            <div class="row">
                                <div class="col-lg-10 col-lg-offset-1">
                                    <a href="javascript:void(0)" class="more_detail content-link" data-
                                       toggle="modal">
                                        <div class="caption">
                                            <div class="caption-content">
                                                <i class="fa fa-hand-o-right fa-3x"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <img class="event_img img-rounded"
                                                 src="{{asset('uploads/activity/'.$activities[$i]->picture)}}">
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-10 col-lg-offset-1">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <h4>{{$activities[$i]->name}}</h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-1">
                                            <img src="{{asset('static/images/my/activity/address.png')}}">
                                        </div>
                                        <div class="col-lg-10 address_div">
                                            <span class="activity_address">{{$activities[$i]->address}}</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-1">
                                            <img src="{{asset('static/images/my/activity/time.png')}}">
                                        </div>
                                        <div class="col-lg-10 time_div">
                                            <span class="activity_time">{{date('Y-m-d H:i:s',$activities[$i]->time)}}</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-1">
                                            <img src="{{asset('static/images/my/activity/sponsor1.svg')}}">
                                        </div>
                                        <div class="col-lg-10 time_div">
                                            <span class="activity_time"><a class="activity_sponsor_link"
                                                                           href="{{url('user/'.$activities[$i]->sponsorId)}}">{{$sponsors[$i]}}</a></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <a class="activity_people_link"
                                           href="{{url('my/showActivityPeople/'.$activities[$i]->id)}}">
                                            <div class="col-lg-4">
                                                <h5>已报名：</h5>
                                            </div>
                                            <div class="col-lg-6 people_num_div">
                                                <h4 class="h4_num">{{$activities[$i]->peopleSign}}</h4><span
                                                        class="sprit"> /</span><h4 class="h4_num">
                                                    &nbsp;{{$activities[$i]->peopleLimit}}</h4>
                                            </div>
                                        </a>
                                        <div class="col-lg-2 col-lg-offset-1">
                                            @if(!$user->isAdmin)
                                                @if($user->id!=$activities[$i]->sponsorId)
                                                    @if($activities[$i]->time < time())
                                                        <img width="53" height="34"
                                                             src="{{asset('static/images/my/activity/timeout.png')}}">
                                                    @elseif($activities[$i]->peopleSign == $activities[$i]->peopleLimit && $attend[$i]!=1)
                                                        <img width="53" height="34"
                                                             src="{{asset('static/images/my/activity/full.png')}}">
                                                    @else
                                                        <button onclick="joinActivity(this,{{$user->id}},{{$activities[$i]->id}},{{$activities[$i]->time}});"
                                                                type="button"
                                                                class="{{$attend[$i]==1?'btn-warning':'btn-primary'}} join_btn btn">{{$attend[$i]==1?'取消参与':'参与'}}</button>
                                                    @endif
                                                @else
                                                    <button onclick="deleteActivity({{$activities[$i]->id}},{{$activities[$i]->time}});"
                                                            type="button" class="off_btn btn btn-primary">下台
                                                    </button>
                                                @endif
                                            @else
                                                <button onclick="deleteActivity({{$activities[$i]->id}},{{$activities[$i]->time}});"
                                                        type="button" class="off_btn btn btn-primary">下台
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 content-item event_detail_div">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        详情
                                    </h3>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-12 event_detail_content">{{$activities[$i]->detail}}</div>
                                        <div class="col-lg-1 col-lg-offset-10">
                                            <a class="back_to_introduction" href="javascript:void(0)"><img
                                                        class="back_icon"
                                                        src="{{asset('static/images/my/activity/back.png')}}"></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endfor
            </div>

            {{--分页--}}
            <div class="row" id="desc_div">
                <div class="col-lg-4">
                    <div class="row" role="toolbar" style="margin-top: 20px">
                        <div class="col-lg-6" style="margin-left: 15px">
                            {{--@if($user->isAdmin)--}}
                            <a href="{{count(explode('/',Request::getPathInfo()))==5?url('my/activity/start/'.explode('/',Request::getPathInfo())[4]):
                            url('my/activity/start')}}">
                                <button type="button"
                                        class="{{Request::getPathInfo()=="/my/activity/start"?'active':''}} btn btn-info">
                                    按活动开始时间降序
                                </button>
                            </a>
                        </div>
                        <div class="col-lg-6" style="margin-left: -20px">
                            <a href="{{count(explode('/',Request::getPathInfo()))==5?url('my/activity/release/'.explode('/',Request::getPathInfo())[4]):
                            url('my/activity/release')}}">
                                <button id="release_desc_btn" type="button"
                                        class="{{Request::getPathInfo()=="/my/activity/release"?'active':''}} btn btn-info">
                                    按活动发布时间降序
                                </button>
                            </a>
                            {{--@else--}}
                            {{--@endif--}}
                        </div>
                    </div>
                </div>


                <div class="col-lg-5">
                    <div class="row" style="margin-top: 20px">
                        <div class="col-lg-10">
                            {{--<form name="search_user" class="form-horizontal" method="post">--}}
{{--                                {{csrf_field()}}--}}
                                <input type="text" name="activity_name" class="form-control" id="activity_name"
                                       placeholder="请输入您要搜索的活动">
                            {{--</form>--}}
                        </div>
                        <div class="col-lg-2">
                            <span>
                                <input onclick="searchActivities();" onmouseover="searchIn(this);"
                                       onmouseout="searchOut(this);" type="image"
                                       src="{{asset('static/images/my/friend/search.png')}}">
                            </span>
                            <script type="text/javascript">
                                function searchActivities() {
                                    var name = document.getElementById('activity_name').value;
                                    if (name == '') {
                                        return;
                                    }
                                    window.location = "/relax/public/my/activity/start/" + name;
                                }

                                function searchIn(img) {
                                    $(img).attr('src', '/relax/public/static/images/my/friend/search1.png');
                                }

                                function searchOut(img) {
                                    $(img).attr('src', '/relax/public/static/images/my/friend/search.png');
                                }

                            </script>
                        </div>
                    </div>
                </div>


                <div class="col-lg-3">
                    <div class="pull-right">
                        {{$activities->render()}}
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>