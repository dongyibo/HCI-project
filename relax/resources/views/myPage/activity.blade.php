@extends('common.templet')

@section('nav')
    @include('common.navigation')
@stop

@section('logout')
    <a href="{{url('home/userLogout')}}">
        <img onmouseover="logoutIn(this);" onmouseout="logoutOut(this);" title="注销"
             src="{{asset('static/images/admin/nav/logout.png')}}"/>
    </a>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12 text-center">
            <h2>活&nbsp;&nbsp;动</h2>
            <hr class="star-primary">
        </div>
    </div>

    {{--<div class="row" style="margin-bottom: 20px;margin-left: -25px">--}}
    {{--<div class="btn-group">--}}
    {{--<button type="button" onclick="jumpToList();" class="btn btn-primary">活动列表</button>--}}
    {{--<button type="button" onclick="jumpToRelease();" class="btn btn-primary">发布活动</button>--}}
    {{--</div>--}}
    {{--</div>--}}
    <ul id="myTab" class="nav nav-tabs" style="margin-bottom: 20px;margin-left: -25px">
        <li class="active">
            <a href="#activity_list" data-toggle="tab" style="font-size: larger">
                活动展示
            </a>
        </li>
        <li><a href="#release_activity" data-toggle="tab" style="font-size: larger">发布活动</a></li>
    </ul>

    <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade in active" id="activity_list">
            @include('common.hotActivities')

            @include('common.activityList')
        </div>

        <div class="tab-pane fade" id="release_activity">
            <div id="activity_alert_div" class="row">
                <div class="col-lg-12">
                    <div id="activity_alert" class="alert alert-success" style="display: none;">
                    </div>
                </div>
            </div>

            <div class="row" style="padding-left: 100px">
                <div class="panel-default" style="border: 0 solid transparent;background-color: #FDF9F4">
                    {{--<div class="row">--}}
                    {{--<div class="content-title">--}}
                    {{--<span>发布活动</span>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12" id="info_div">
                                <div class="form-horizontal">{{--{{url('User/save')}}--}}

                                    {{csrf_field()}} {{-- 生成一个隐藏的表单，生成一个token字段 --}}

                                    <div class="form-group">
                                        <label for="name" class="col-lg-3 control-label">名称<span style="color: red">*</span></label>

                                        <div class="col-lg-5">
                                            <input type="text" name="Activity[name]" class="form-control input_data"
                                                   id="name"
                                                   placeholder="请输入活动名称">
                                        </div>
                                        <div class="col-lg-4">
                                            <p class="form-control-static text-danger" id="name_error"></p>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="address" class="col-lg-3 control-label">地点<span style="color: red">*</span></label>

                                        <div class="col-lg-5">
                                            <input type="text" name="Activity[address]" class="form-control input_data"
                                                   id="address" placeholder="请输入活动地点">
                                        </div>
                                        <div class="col-lg-4">
                                            <p class="form-control-static text-danger" id="address_error"></p>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="time" class="col-lg-3 control-label">时间<span style="color: red">*</span></label>
                                        <div class="col-lg-5">
                                            <div class="row">
                                                <div class="col-lg-1" style="width: 24%">
                                                    <select id="year" class="form-control">
                                                        <option>2017</option>
                                                        <option>2018</option>
                                                        <option>{{date('m')}}</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-1 time_detail" style="width:1%">年</div>

                                                <div class="col-lg-1" style="width: 20%">
                                                    <select id="month" class="form-control">
                                                        @for($i=1;$i<13;$i++)
                                                            @if($i>=1&&$i<10)
                                                                @if(date('n')==$i)
                                                                    <option selected="selected">0{{$i}}</option>
                                                                @else
                                                                    <option>0{{$i}}</option>
                                                                @endif
                                                            @else
                                                                @if(date('n')==$i)
                                                                    <option selected="selected">{{$i}}</option>
                                                                @else
                                                                    <option>{{$i}}</option>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div class="col-lg-1 time_detail" style="width:1%">月</div>

                                                <div class="col-lg-1" style="width: 20%">
                                                    <select id="day" class="form-control">
                                                        @for($i=1;$i<=31;$i++)
                                                            @if($i>=1&&$i<10)
                                                                @if(date('d')==$i)
                                                                    <option selected="selected">0{{$i}}</option>
                                                                @else
                                                                    <option>0{{$i}}</option>
                                                                @endif
                                                            @else
                                                                @if(date('d')==$i)
                                                                    <option selected="selected">{{$i}}</option>
                                                                @else
                                                                    <option>{{$i}}</option>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div class="col-lg-1 time_detail" style="width:1%">日</div>
                                            </div>

                                            <div class="row time_row_div">
                                                <div class="col-lg-1" style="width: 24%">
                                                    <select id="hour" class="form-control">
                                                        @for($i=0;$i<24;$i++)
                                                            @if($i>=0&&$i<10)
                                                                @if($i==6)
                                                                    <option selected="selected">0{{$i}}</option>
                                                                @else
                                                                    <option>0{{$i}}</option>
                                                                @endif
                                                            @else
                                                                <option>{{$i}}</option>
                                                            @endif
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div class="col-lg-1 time_detail" style="width:1%">时</div>

                                                <div class="col-lg-1 time_modify" style="width: 20%">
                                                    <select id="minute" class="form-control">
                                                        @for($i=0;$i<60;$i++)
                                                            @if($i>=0&&$i<10)
                                                                <option>0{{$i}}</option>
                                                            @else
                                                                <option>{{$i}}</option>
                                                            @endif
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div class="col-lg-1 time_detail" style="width:1%">分</div>

                                                <div class="col-lg-1 time_modify" style="width: 20%">
                                                    <select id="second" class="form-control">
                                                        @for($i=0;$i<60;$i++)
                                                            @if($i>=0&&$i<10)
                                                                <option>0{{$i}}</option>
                                                            @else
                                                                <option>{{$i}}</option>
                                                            @endif
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div class="col-lg-1 time_detail" style="width:1%">秒</div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <p class="form-control-static text-danger"></p>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="peopleLimit" class="col-lg-3 control-label">限定人数<span style="color: red">*</span></label>

                                        <div class="col-lg-5">
                                            <input type="text" name="Activity[peopleLimit]"
                                                   class="form-control input_data"
                                                   id="peopleLimit" placeholder="请输入人数上限">
                                        </div>
                                        <div class="col-lg-4">
                                            <p class="form-control-static text-danger" id="limit_error"></p>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="detail" class="col-lg-3 control-label">详情&nbsp;&nbsp;</label>

                                        <div class="col-lg-5">
                                    <textarea id="detail" name="Activity[detail]" class="form-control" rows="3"
                                              placeholder="请输入活动描述（100字以内）"></textarea>
                                        </div>
                                        <div class="col-lg-4">
                                            <p class="form-control-static text-danger" id="detail_error"></p>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {!! Form::open( [ 'url' => ["ajax/activityImg"], 'method' => 'POST', 'id' => 'upload_img', 'files' => true ] ) !!}
                                        <label for="detail" class="col-lg-3 control-label">图片<span style="color: red">*</span></label>

                                        <div class="col-lg-1" style="margin-top: 5px">
                                            <button type="button" class="btn btn-default btn-xs" onclick="showArea();">添加图片</button>
                                        </div>

                                        <div class="col-lg-6" id="file_path_icon" style="margin-left: -15px;display: none;padding-top: 3px">
                                            <span style="" id="file_path"></span>
                                            <button style="float: none" type="button" class="close" data-dismiss="alert"
                                                    aria-hidden="true" onclick="closeArea();">
                                                &times;
                                            </button>
                                        </div>

                                        <div class="col-lg-1">
                                            <input type="file" onchange="fileChanged();" id="activity_file" name="activity_img" style="display: none">
                                        </div>

                                        {!! Form::close() !!}
                                    </div>

                                    <div class="form-group" id="check_btn_div" style="margin-top: 30px">
                                        <div class="col-lg-offset-5 col-lg-2">
                                            <button id="release_btn" type="button" class="btn btn-primary"
                                                    onclick="releaseActivity({{$user->id}});">发布
                                            </button>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-5" style="margin-left: 38%">
                                            <h5>(备注：<span style="color: red">*</span> 为必填必选项)</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop


@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('static/css/auxiliary.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('static/css/activity.css')}}"/>
    <script type="text/javascript" src="{{asset('static/js/pptBox.js')}}"></script>
    <script src="{{asset('static/js/avatarHandle.js')}}"></script>
    <script src="{{asset('static/js/activity.js')}}"></script>
@stop

@section('javascript')
    <script type="text/javascript" src="{{asset('static/js/activity.js')}}"></script>
    <script src="{{asset('static/js/avatarHandle.js')}}"></script>
@stop