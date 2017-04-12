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
            <h2>社交</h2>
            <hr class="star-primary">
        </div>
    </div>


    <div id="friend_alert_div" class="row">
        <div class="col-lg-8 col-lg-offset-2">
            <div id="friend_alert" class="alert alert-success" style="display: none;">
            </div>
            <div id="blog_alert" class="alert alert-danger" style="display: none;">
            </div>
        </div>
    </div>
    @if(isset($success))
        <script>
            $('#friend_alert').show();
            $('#friend_alert').text('动态发布成功!');
            $('#friend_alert').fadeOut(2000);
        </script>
    @endif
    {{--@if(isset($picError))--}}
    {{--<script>--}}
    {{--$('#blog_alert').show();--}}
    {{--$('#blog_alert').text({{$picError}});--}}
    {{--$('#blog_alert').fadeOut(2000);--}}
    {{--</script>--}}
    {{--        {{$picError}}--}}
    {{--@endif--}}

    @include('common.search')

    @if(count($infos)>0)
        <div class="row" id="info_remind_div">
            <div class="col-lg-4 col-lg-offset-5 info_to_read">
                <button onclick="showInfos({{$user->id}});" type="button" class="btn btn-danger">您有 {{count($infos)}}
                    条未读消息
                </button>
            </div>
        </div>

        <div class="row" id="info_record_div">
            <div class="col-lg-8 col-lg-offset-2 info_to_read">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <ul class="list-group">
                            @foreach($infos as $info)
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <h5>{{$info->username}} 给您的动态<span
                                                        class="record_content">"{{substr($info->content,0,6)}}
                                                    ......"</span>
                                                @if(isset($info->commentId))
                                                    评论了
                                                @else
                                                    点赞了
                                                @endif
                                            </h5>
                                        </div>
                                        <div class="col-lg-3 col-lg-offset-1">
                                            <h5>{{date('Y-m-d H:i:s',$info->created_at)}}</h5>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        <div class="col-lg-row">
                            <div class="col-lg-1 col-lg-offset-11">
                                <div class="col-lg-1 col-lg-offset-5">
                                    <a href="javascript:closeRecord();"><img
                                                src="{{asset('static/images/my/friend/close2.png')}}"></a>
                                </div>
                                <script type="text/javascript">
                                    function closeRecord() {
                                        document.getElementById('info_remind_div').style.display = 'none';
                                        document.getElementById('info_record_div').style.display = 'none';
                                    }
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="row friend_div">
        <div class="col-lg-4 friend_list">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <a href="javascript:void(0)" onclick="showFriends();" id="friend_link"
                           class="active">关注列表(<span id="fork_count">{{count($friends)}}</span>)</a> /
                        <a id="fan_link" href="javascript:void(0)" onclick="showFans();">粉丝列表({{count($fans)}})</a>
                    </h3>
                </div>
                <div class="panel-body">
                    {{--好友列表--}}
                    <ul class="list-group" id="friend_list">
                        @if(count($friends)==0)
                            你还没关注任何用户哦，赶紧搜索一些吧~
                        @endif
                        @foreach($friends as $friend)
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-lg-1">
                                        <a href="{{url('user/'.$friend->id)}}">
                                            <img class="friend_list_avatar"
                                                 src="{{$friend->portrait?asset('uploads/avatar/'.$friend->portrait):asset('static/images/my/temp.png')}}">
                                        </a>
                                    </div>
                                    <div class="col-lg-6">
                                        <span>{{$friend->username}}</span>
                                    </div>
                                    <div class="col-lg-1 col-lg-offset-2" style="padding-top: 3px">
                                        <a href="{{url('user/'.$friend->id)}}"><img title="用户资料"
                                                                                    class="friend_list_icon"
                                                                                    src="{{asset('static/images/my/friend/detail.svg')}}"></a>
                                    </div>
                                    <div class="col-lg-1 delete_div_fork">
                                        {{--<a onclick="cancelFork({{$user->id}},{{$friend->id}},this);"><img class="friend_list_icon" src="{{asset('static/images/my/friend/delete.png')}}"></a>--}}
                                        <input title="取消关注" class="friend_list_icon"
                                               onclick="cancelFork({{$user->id}},{{$friend->id}},this);" type="image"
                                               src="{{asset('static/images/my/friend/delete.png')}}">
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    @if(count($friends)>0)
                        <div class="row" id="compare_btn">
                            <div class="col-lg-2 col-lg-offset-4">
                                <a href="{{url('compare/'.$user->id)}}">
                                    <button class="btn btn-primary">好友数据排名</button>
                                </a>
                            </div>
                        </div>
                    @endif

                    <ul class="list-group" id="fan_list" style="display: none;">
                        @foreach($fans as $fan)
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-lg-1">
                                        <a href="{{url('user/'.$fan->id)}}">
                                            <img class="friend_list_avatar"
                                                 src="{{$fan->portrait?asset('uploads/avatar/'.$fan->portrait):asset('static/images/my/temp.png')}}">
                                        </a>
                                    </div>
                                    <div class="col-lg-6">
                                        <span>{{$fan->username}}</span>
                                    </div>
                                    <div class="col-lg-1 col-lg-offset-3" style="padding-top: 4px">
                                        <a href="{{url('user/'.$fan->id)}}"><img title="用户资料"
                                                                                 class="friend_list_icon"
                                                                                 src="{{asset('static/images/my/friend/detail.svg')}}"></a>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        {{--发表动态--}}
        <div class="col-lg-8 blog_self_div">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">发表动态</h3>
                </div>
                <div class="panel-body">
                    {{--文本框--}}
                    <form enctype="multipart/form-data" name="blogForm" role="form" method="POST"
                          action="{{url('my/blog/'.$user->id)}}">
                        {{csrf_field()}}
                        <div class="form-group">
                            <textarea id="blogContent" name="blogContent" placeholder="分享你的点点滴滴吧~" class="form-control"
                                      rows="3"></textarea>
                            <input type="file" name="blogImg" id="blog_file" onchange="fileChange();"
                                   style="display: none">
                        </div>
                    </form>
                </div>
                <div class="row publish_div">
                    <div class="row">
                        <div class="col-lg-3 error_prompt_div">
                            <p class="error_prompt_p">
                                @if(isset($picError))
                                    {{$picError}}
                                @endif
                            </p>
                        </div>
                        <div class="col-lg-9">
                            <div class="col-lg-5 btn-group btn_double_group_div">
                                <button onclick="addPic();" type="button" class="btn btn-primary">添加图片</button>
                                <button onclick="releaseBlog();" type="button" class="btn btn-primary">发布</button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-lg-offset-9" id="file_path_icon" style="display:none;">
                            <span id="file_path"></span>
                            <button style="float: none" type="button" class="close" data-dismiss="alert"
                                    aria-hidden="true" onclick="deleteFile();">
                                &times;
                            </button>
                            {{--<a href="javascript:void(0)">--}}
                                {{--<img onclick="deleteFile();" src="{{asset('static/images/my/friend/close1.png')}}">--}}
                            {{--</a>--}}
                        </div>
                    </div>
                    <script type="text/javascript">
                        function releaseBlog() {
                            var blog = document.getElementById('blogContent').value;
                            if (blog == '') {
                                $('#blog_alert').show();
                                $('#blog_alert').text('不能发空消息哦~');
                                $('#blog_alert').fadeOut(2000);
//                                alert('不能发空消息哦~');
                                return;
                            }
                            document.blogForm.submit();
                        }
                    </script>
                </div>
            </div>
            {{--朋友圈--}}
            <div class="container blog_div">
                @foreach($blogs as $blog)
                    <div class="row">
                        {{--每条动态--}}
                        <div class="col-lg-1">
                            <img class="img-rounded blog_avatar"
                                 src="{{$blog->portrait?asset('uploads/avatar/'.$blog->portrait):asset('static/images/my/temp.png')}}">
                        </div>
                        <div class="col-lg-5">
                            <h4>{{$blog->username}}</h4>
                        </div>
                        <div class="col-lg-3 col-lg-offset-2" style="padding-left: 40px">
                            <h5>{{date('Y-m-d H:i:s',$blog->created_at)}}</h5>
                        </div>
                        @if($blog->userId==$user->id)
                            <div class="col-lg-1" style="padding-top: 7px;padding-left: 2px">
                                <a href="javascript:void(0)"><img title="删除动态"
                                                                  onclick="deleteBlog(this,{{$blog->blogId}});"
                                                                  src="{{asset('static/images/my/friend/delete1.png')}}"
                                                                  onmouseover="deleteIn(this);"
                                                                  onmouseout="deleteOut(this);"/></a>
                            </div>
                        @endif
                        <div class="col-lg-12 blog_content_div">
                            <p class="blog_content">{{$blog->content}}</p>
                        </div>
                        @if($blog->picture)
                            <div class="col-lg-12">
                                <img class="blog_img" src="{{asset('uploads/blog/'.$blog->picture)}}">
                            </div>
                        @endif
                        <div class="col-lg-2 col-lg-offset-9 blog_praise_div">
                            <div class="col-lg-4 col-lg-offset-2">
                                <a class="praise_btn" href="javascript:void(0)"><img
                                            onclick="praise(this,{{$user->id}},{{$blog->blogId}});" class="blog_icon"
                                            onmouseover="praiseIn(this);" onmouseout="praiseOut(this);"
                                            src="{{isset($blog->praiseOwn)?asset('static/images/my/friend/praise1.png'):asset('static/images/my/friend/praise.png')}}"></a>
                            </div>
                            <div class="col-lg-6 praise_count_div">
                                @if(isset($praises[$blog->blogId]))
                                    <h5 class="praise_h5">{{count($praises[$blog->blogId])}}</h5>
                                @endif
                            </div>
                        </div>

                        {{--@if(isset($blog->praiseOwn))--}}
                        {{--hahah--}}
                        {{--@endif--}}
                        <div class="col-lg-1 blog_comment_div">
                            <a class="comment_btn" href="javascript:void(0)">
                                <img onmouseover="commentIn(this);" onmouseout="commentOut(this);" class="blog_icon"
                                     src="{{asset('static/images/my/friend/comment.png')}}">
                            </a>
                        </div>

                        <div class="col-lg-12">
                            @if(isset($praises[$blog->blogId]))
                                @foreach($praises[$blog->blogId] as $praise)
                                    <h5 class="praise_users">{{$praise['username']}}</h5>
                                @endforeach
                                <h5 class="praise_users_set">觉得很赞</h5>
                            @endif
                        </div>

                        <div class="col-lg-12">
                            @if(isset($comments[$blog->blogId]))
                                @foreach($comments[$blog->blogId] as $comment)
                                    <div class="row comment_content"
                                         onmouseover="showDelete(this,{{$user->id}},{{$comment['userId']}});"
                                         onmouseout="hideDelete(this,{{$user->id}},{{$comment['userId']}});">
                                        <span class="comment_name">{{$comment['username']}}</span>
                                        <span class="comment_name_colon">:</span>
                                        <span>{{$comment['content']}}</span>
                                        <a class="delete_span" href="javascript:void(0)"><span><img
                                                        onclick="deleteComment(this,{{$comment['commentId']}});"
                                                        src="{{asset('static/images/my/friend/delete2.png')}}"></span></a>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="comment_area panel-body col-lg-12 blog_comment_textarea">
                            {{--文本框--}}
                            <form role="form">
                                <div class="form-group">
                                    {{--<label for="name">文本框</label>--}}
                                    <textarea placeholder="发表您的观点吧~" class="form-control" rows="3"></textarea>
                                </div>
                            </form>
                            <div class="col-lg-1">
                                <a class="send_btn" href="javascript:void(0)"><img
                                            onclick="releaseComment(this,{{$blog->blogId}},{{$user->id}});"
                                            class="blog_icon" src="{{asset('static/images/my/friend/ok.png')}}"></a>
                            </div>
                            <div class="col-lg-1 blog_close_div">
                                <a class="close_btn" href="javascript:void(0)"><img class="blog_icon"
                                                                                    src="{{asset('static/images/my/friend/close.png')}}"></a>
                            </div>
                        </div>
                    </div>
                    <HR class="HR" style="FILTER: progid:DXImageTransform.Microsoft.Glow(color=#987cb9,strength=10)"
                        width="100%" color=#987cb9 SIZE=1>
                @endforeach
            </div>
        </div>
    </div>
@stop

<script>
    function commentIn(img) {
        $(img).attr('src', '/relax/public/static/images/my/friend/comment2.png');
    }

    function commentOut(img) {
        $(img).attr('src', '/relax/public/static/images/my/friend/comment.png');
    }

    function deleteIn(img) {
        $(img).attr('src', '/relax/public/static/images/my/friend/delete3.png');
    }

    function deleteOut(img) {
        $(img).attr('src', '/relax/public/static/images/my/friend/delete1.png');
    }

    function praiseIn(img) {
//        alert(window.location.host);
        if ($(img).attr('src') == 'http://' + window.location.host + '/relax/public/static/images/my/friend/praise.png' ||
            $(img).attr('src') == '/relax/public/static/images/my/friend/praise.png') {
            $(img).attr('src', '/relax/public/static/images/my/friend/praise3.png');
        }
        else if ($(img).attr('src') == 'http://' + window.location.host + '/relax/public/static/images/my/friend/praise1.png' ||
            $(img).attr('src') == '/relax/public/static/images/my/friend/praise1.png') {
            $(img).attr('src', '/relax/public/static/images/my/friend/praise2.png');
        }

    }

    function praiseOut(img) {
//        alert($(img).attr('src'));
        if ($(img).attr('src') == 'http://' + window.location.host + '/relax/public/static/images/my/friend/praise3.png' ||
            $(img).attr('src') == '/relax/public/static/images/my/friend/praise3.png') {
            $(img).attr('src', '/relax/public/static/images/my/friend/praise.png');
        }
        else if ($(img).attr('src') == 'http://' + window.location.host + '/relax/public/static/images/my/friend/praise2.png' ||
            $(img).attr('src') == '/relax/public/static/images/my/friend/praise2.png') {
            $(img).attr('src', '/relax/public/static/images/my/friend/praise1.png');
        }
    }
</script>

@section('css')
    <link href="{{asset('static/css/auxiliary.css')}}" rel="stylesheet">
    <script src="{{asset('static/js/fork.js')}}"></script>
    <link href="{{asset('static/css/friend.css')}}" rel="stylesheet">
    <script src="{{asset('static/js/avatarHandle.js')}}"></script>
    <script src="{{asset('static/js/friend.js')}}"></script>
@stop

@section('javascript')
    <script src="{{asset('static/js/friend.js')}}"></script>
    <script src="{{asset('static/js/avatarHandle.js')}}"></script>
@stop
