<?php
/**
 * Created by PhpStorm.
 * User: 董轶波
 * Date: 2016/10/11 0011
 * Time: 下午 16:08
 */

namespace App\Http\Controllers;

use App\ActivityAttend;
use App\Blog;
use App\Comment;
use App\Friend;
use App\Info;
use App\Libs\Activity\Activity;
use App\Libs\JumpHelper\JumpHelper;
use App\Libs\Sort\Sort;
use App\Member;
use App\Praise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\QueryException;
use App\Libs\Avatar\Avatar;
use Illuminate\Support\Facades\Session;

/**用户资源活动控制器
 * Class EventController
 * @package App\Http\Controllers
 */
class EventController extends Controller
{

    /**
     * 用户活动页面
     */
    public function activity(Request $request, $tag = null, $search = null)
    {
        //按照活动开始时间降序
        if ($tag == 'start') {
            $activities = \App\Activity::latest('time')->paginate(6);
            if ($search != null) {
                $activities = \App\Activity::where('name', 'like', '%' . $search . '%')
                    ->orWhere('address', 'like', '%' . $search . '%')
                    ->latest('time')->paginate(6);
            }
        } //按照活动发布时间降序
        elseif ($tag == 'release') {
            $activities = \App\Activity::latest('created_at')->paginate(6);
            if ($search != null) {
                $activities = \App\Activity::where('name', 'like', '%' . $search . '%')
                    ->orWhere('address', 'like', '%' . $search . '%')
                    ->latest('created_at')->paginate(6);
            }
        }// 删除
        elseif (is_numeric($tag)) {
            $path = \App\Activity::find($tag)->picture;
            \App\Activity::destroy($tag);
            //删除图片文件
            $destination = 'uploads/activity/' . $path;
            Avatar::deleteFile($destination);
            //还要删除活动参与表的该活动相关数据
            ActivityAttend::where(['activityId' => $tag])->delete();
            return redirect('my/activity/release');
        } else {
            $activities = \App\Activity::latest('time')->paginate(6);
        }
        //把用户参与的活动标记出来
        $arr = JumpHelper::jumpUIWith();
        if ($arr) {
            $userId = $arr[0]->id;
        } else {
            return view('errors.503');
        }
        $activities_attend = ActivityAttend::where('userId', '=', $userId)->get();
        $attend = array();
        $i = 0;
        foreach ($activities as $activity) {
            $flag = false;
            foreach ($activities_attend as $activity_attend) {
                if ($activity->id == $activity_attend->activityId) {
                    $attend[$i] = 1;
                    $i++;
                    $flag = true;
                    break;
                }
            }
            if (!$flag) {
                $attend[$i] = 0;
                $i++;
            }
        }
        $activity_sponsors = array();
        $j = 0;
        foreach ($activities as $activity) {
            $username = Member::where('id', '=', $activity->sponsorId)->first()->username;
            $activity_sponsors[$j] = $username;
            $j++;
        }
        return view('myPage.activity', ['user' => $arr[0], 'activity_show' => $arr[1],
            'activities' => $activities, 'attend' => $attend, 'sponsors' => $activity_sponsors]);
    }

    /**
     * 用户朋友圈页面
     */
    public function friend(Request $request)
    {
        date_default_timezone_set("PRC");
        $arr = JumpHelper::jumpUIWith();
        if ($arr) {

            if (Session::get('picError')) {
                //dd(Session::get('picError'));exit;
                return view('myPage.friend', ['user' => $arr[0], 'activity_show' => $arr[1],
                    'friends' => $this->friendDetail($arr[0]->id)['friends'],
                    'blogs' => $this->friendDetail($arr[0]->id)['blogs'],
                    'comments' => $this->friendDetail($arr[0]->id)['comments'],
                    'praises' => $this->friendDetail($arr[0]->id)['praises'],
                    'infos' => $this->friendDetail($arr[0]->id)['infos'],
                    'fans' => $this->friendDetail($arr[0]->id)['fans'],
                    'picError' => Session::get('picError')]);
            } elseif (Session::get('success')) {
                return view('myPage.friend', ['user' => $arr[0], 'activity_show' => $arr[1],
                    'friends' => $this->friendDetail($arr[0]->id)['friends'],
                    'blogs' => $this->friendDetail($arr[0]->id)['blogs'],
                    'comments' => $this->friendDetail($arr[0]->id)['comments'],
                    'praises' => $this->friendDetail($arr[0]->id)['praises'],
                    'infos' => $this->friendDetail($arr[0]->id)['infos'],
                    'fans' => $this->friendDetail($arr[0]->id)['fans'],
                    'success' => 'success']);
            } else {
                return view('myPage.friend', ['user' => $arr[0], 'activity_show' => $arr[1],
                    'friends' => $this->friendDetail($arr[0]->id)['friends'],
                    'blogs' => $this->friendDetail($arr[0]->id)['blogs'],
                    'comments' => $this->friendDetail($arr[0]->id)['comments'],
                    'praises' => $this->friendDetail($arr[0]->id)['praises'],
                    'infos' => $this->friendDetail($arr[0]->id)['infos'],
                    'fans' => $this->friendDetail($arr[0]->id)['fans']]);
            }
        } else {
            return view('errors.503');
        }
    }

    /**
     * 热门用户页面
     */
    public function hotUsers(Request $request)
    {
        //取非管理员用户活跃度最高的前6名
        $users = Member::where('isAdmin', '=', 0)->orderby('activity', 'desc')->take(6)->get();
        $arr = JumpHelper::jumpUIWith();
        if ($arr) {
            return view('myPage.my', ['user' => $arr[0], 'activity_show' => $arr[1], 'users' => $users]);
        } else {
            return view('errors.503');
        }
    }

    /**
     * 用户参与和取消活动
     * @param Request $request
     */
    public function handleActivity(Request $request, $tag)
    {
        $userId = Input::get('userId');
        $activityId = Input::get('activityId');
        //先判断这个活动和用户是否存在（异步操作）
        if ($this->isActivityExist($activityId) && $this->isUserExist($userId)) {
            //参与
            if ($tag == 'attend') {
                $data = array('userId' => $userId, 'activityId' => $activityId);
                //创建新数据
                try {
                    $attend = ActivityAttend::create($data);
                } catch (QueryException $e) {
                    return response()->json(array('msg' => '活动已报名'));
                }
                //活动报名人数加1
                $activity = \App\Activity::find($activityId);
                $activity->peopleSign += 1;
                $activity->save();
                return response()->json(array('msg' => '活动报名成功'));
            } //取消参与
            else {
                ActivityAttend::where(['activityId' => $activityId, 'userId' => $userId])->delete();
                //活动报名人数减1
                $activity = \App\Activity::find($activityId);
                $activity->peopleSign -= 1;
                $activity->save();
                return response()->json(array('msg' => '取消成功'));
            }
        } else {
            return response()->json(array('msg' => '数据异常'));
        }
    }

    /**
     * 搜索用户
     */
    public function searchUsers(Request $request)
    {
        date_default_timezone_set("PRC");
        $name = $request->input('username');
        $users = Member::where('username', 'like', '%' . $name . '%')
            ->where(function ($query) {
                $query->where('isAdmin', '=', 0);
            })->paginate(6);;
        $arr = JumpHelper::jumpUIWith();
        if ($arr) {
            return view('myPage.friend', ['user' => $arr[0], 'activity_show' => $arr[1],
                'users' => $users, 'friends' => $this->friendDetail($arr[0]->id)['friends'],
                'blogs' => $this->friendDetail($arr[0]->id)['blogs'],
                'comments' => $this->friendDetail($arr[0]->id)['comments'],
                'praises' => $this->friendDetail($arr[0]->id)['praises'],
                'infos' => $this->friendDetail($arr[0]->id)['infos'],
                'fans' => $this->friendDetail($arr[0]->id)['fans']]);
        } else {
            return view('errors.503');
        }

    }


    /**
     * 关注用户
     */
    public function forkUser()
    {
        $userId = Input::get('userId');
        $friendId = Input::get('friendId');
        if ($userId == $friendId) {
            return response()->json(array('msg' => '您不能关注自己'));
        }
        $arr = ['userId' => $userId, 'friendId' => $friendId];
        $user = Friend::where($arr)->first();
        if ($user) {
            return response()->json(array('msg' => '该用户您已关注'));
        }
        //判断是否超出权限
        $haveForked = Friend::where('userId', '=', 5)->count();
        if (!Activity::canFork(Member::find($userId)->level, $haveForked)) {
            return response()->json(array('msg' => '已达上限，您需要更高的等级才能关注~'));
        }
        //成功
        $newFriend = Friend::create($arr);
        $avatar = Member::find($friendId)->portrait;
        $name = Member::find($friendId)->username;
        return response()->json(array('msg' => '关注成功!', 'success' => true, 'avatar' => $avatar,
            'name' => $name));
    }

    /**
     * 取消关注用户
     */
    public function cancelFork()
    {
        $userId = Input::get('userId');
        $friendId = Input::get('friendId');
        Friend::where(['userId' => $userId, 'friendId' => $friendId])->delete();
        return response()->json(array('msg' => 'success'));
    }

    /**
     * 判断某个活动是否存在（防止异步操作）
     * @param $id
     * @return mixed
     */
    private function isActivityExist($id)
    {
        return $activity = \App\Activity::find($id);
    }

    /**
     * 判断某个用户是否存在（防止异步操作）
     * @param $id
     * @return mixed
     */
    private function isUserExist($id)
    {
        return Member::find($id);
    }

    /**
     * 消息圈细节
     * @param $id
     */
    private function friendDetail($id)
    {
        //关注列表
        $friends = array();
        $friendIds = Friend::where(['userId' => $id])->where('friendId', '<>', $id)->get();
        foreach ($friendIds as $ids) {
            $friends[] = Member::find($ids->friendId);
        }
        //动态列表
        $blogs = DB::table('relax_blog')
            ->join('relax_friend', 'relax_blog.userId', '=', 'relax_friend.friendId')
            ->join('relax_user', 'relax_blog.userId', '=', 'relax_user.id')
            ->select('relax_blog.*', 'relax_user.username', 'relax_user.portrait')
            ->where('relax_friend.userId', '=', $id)
            ->orderBy('relax_blog.created_at', 'desc')
            ->get();
        //评论
        $comments = DB::table('relax_comment')
            ->join('relax_blog', 'relax_blog.blogId', '=', 'relax_comment.blogId')
            ->join('relax_friend', 'relax_blog.userId', '=', 'relax_friend.friendId')
            ->join('relax_user', 'relax_user.id', '=', 'relax_comment.userId')
            ->select('relax_comment.*', 'relax_user.username')
            ->where('relax_friend.userId', '=', $id)
            ->orderBy('relax_blog.created_at', 'desc')
            ->orderBy('relax_comment.created_at', 'asc')
            ->get();
        $arrComment = array();
        foreach ($comments as $comment) {
            $temp = ['userId' => $comment->userId, 'username' => $comment->username,
                'content' => $comment->content, 'commentId' => $comment->commentId];
            $arrComment[$comment->blogId][] = $temp;
        }
        //点赞
        $praises = DB::table('relax_praise')
            ->join('relax_blog', 'relax_blog.blogId', '=', 'relax_praise.blogId')
            ->join('relax_friend', 'relax_blog.userId', '=', 'relax_friend.friendId')
            ->join('relax_user', 'relax_user.id', '=', 'relax_praise.userId')
            ->select('relax_praise.*', 'relax_user.username')
            ->where('relax_friend.userId', '=', $id)
            ->orderBy('relax_blog.created_at', 'desc')
            ->orderBy('relax_praise.created_at', 'desc')
            ->get();
        $arrPraise = array();
        foreach ($praises as $praise) {
            $temp = ['username' => $praise->username];
            $arrPraise[$praise->blogId][] = $temp;
        }
        //最近未读消息列表
        $infos = $this->infoWithoutReading($id);

        //自己点过的赞
        $praiseOwns = DB::table('relax_praise')
            ->select('relax_praise.blogId')
            ->where('relax_praise.userId', '=', $id)
            ->get();
        foreach ($blogs as $blog) {
            foreach ($praiseOwns as $praiseOwn) {
                if ($blog->blogId == $praiseOwn->blogId) {
                    $blog->praiseOwn = true;
                }
            }
        }

        //自己的粉丝
        $fans = array();
        $fanIds = Friend::where(['friendId' => $id])->where('userId', '<>', $id)->get();
        foreach ($fanIds as $ids) {
            $fans[] = Member::find($ids->userId);
        }

        return array('friends' => $friends, 'blogs' => $blogs, 'comments' => $arrComment,
            'praises' => $arrPraise, 'infos' => $infos, 'fans' => $fans);
    }

    /**
     * 处理最近未读消息
     * @param $id
     */
    private function infoWithoutReading($id)
    {
        date_default_timezone_set("PRC");
        //取出未读的消息（对自己的点赞和评论，时间降序）
        $maxTime = Info::where(['userId' => $id])->first()->time;
        //点赞
        $praises = DB::table('relax_praise')
            ->join('relax_blog', 'relax_blog.blogId', '=', 'relax_praise.blogId')
            ->join('relax_user', 'relax_user.id', '=', 'relax_praise.userId')
            ->select('relax_praise.*', 'relax_user.username', 'relax_blog.content')
            ->where('relax_blog.userId', '=', $id)
            ->where('relax_praise.userId', '<>', $id)
            ->where('relax_praise.created_at', '>', $maxTime)
            ->orderBy('relax_praise.created_at', 'desc')
            ->get();
        //评论
        $comments = DB::table('relax_comment')
            ->join('relax_blog', 'relax_blog.blogId', '=', 'relax_comment.blogId')
            ->join('relax_user', 'relax_user.id', '=', 'relax_comment.userId')
            ->select('relax_comment.*', 'relax_user.username', 'relax_blog.content')
            ->where('relax_blog.userId', '=', $id)
            ->where('relax_comment.userId', '<>', $id)
            ->where('relax_comment.created_at', '>', $maxTime)
            ->orderBy('relax_comment.created_at', 'desc')
            ->get();
        //整理
        $arr = Sort::mergeArray($praises, $comments);
        return $arr;
    }


    /**
     * 用户发布微博
     */
    public function releaseBlog(Request $request, $id)
    {
        $content = $request->input('blogContent');
        $file = Input::file('blogImg');
        $path = '0';
        if ($file) {
            $file_arr = array();
            $file_arr['name'] = $file->getClientOriginalName();
            $file_arr['size'] = $file->getSize();
            $file_arr['type'] = $file->getMimeType();
            $file_arr['tmp_name'] = $file->getRealPath();
            $file_arr['error'] = $file->getError();
            //图片上传
            $msg = Avatar::uploadFile($file_arr, 'uploads/blog');
            //如果文件上传成功
            if (is_array($msg)) {
                //得到路径
                $new_path = $msg[0];
                $split = explode('/', $new_path);
                //将图片途径添加上
                $path = end($split);
            } else {
                //dd($msg);exit;
                return redirect('my/friend')->with('picError', $msg);
            }
        }
        //创建微博
        $blog = Blog::create(['userId' => $id, 'content' => $content, 'picture' => $path]);
        return redirect('my/friend')->with('success', 'success');

    }

    /**
     * 用户发表评论
     */
    public function releaseComment(Request $request)
    {
        $userId = Input::get('userId');
        $blogId = Input::get('blogId');
        $content = Input::get('content');
        //插入评论
        $comment = Comment::create(['userId' => $userId, 'blogId' => $blogId, 'content' => $content]);
        $commentId = $comment->id;
        //返回评论者用户名
        $name = Member::find($userId)->username;
        return response()->json(array('username' => $name, 'commentId' => $commentId));
    }

    /**
     * 删除评论
     * @param Request $request
     */
    public function deleteComment(Request $request)
    {
        $commentId = Input::get('commentId');
        Comment::where('commentId', '=', $commentId)->delete();
        return response()->json(array('msg' => $commentId));
    }

    /**
     * 删除微博
     * @param Request $request
     */
    public function deleteBlog(Request $request)
    {
        $blogId = Input::get('blogId');
//        $path=Blog::find($blogId)->picture;
        $blog = Blog::where('blogId', '=', $blogId)->first();
        $path = $blog->picture;
        Blog::where('blogId', '=', $blogId)->delete();
        //删除图片文件
        Avatar::deleteFile('uploads/blog/' . $path);
        //删除相关评论和点赞
        Comment::where('blogId', '=', $blogId)->delete();
        Praise::where('blogId', '=', $blogId)->delete();

        return response()->json(array('msg' => $blogId));
    }

    /**
     * 点赞
     */
    public function praise(Request $request)
    {
        $userId = Input::get('userId');
        $blogId = Input::get('blogId');
        try {
            $praise = Praise::create(['blogId' => $blogId, 'userId' => $userId]);
            //返回已经有的赞
            $count = Praise::where(['blogId' => $blogId])->count();
            $user = Member::find($userId);
            $name = $user->username;
            return response()->json(array('count' => $count, 'name' => $name, 'msg' => 'support'));
        } catch (QueryException $e) {
            //取消赞,删除
            Praise::where(['blogId' => $blogId, 'userId' => $userId])->delete();
            $count = Praise::where(['blogId' => $blogId])->count();
            $user = Member::find($userId);
            $name = $user->username;
            return response()->json(array('count' => $count, 'name' => $name, 'msg' => 'cancel'));
        }
    }

    /**
     * 刷新记录
     */
    public function recordInfo()
    {
        $userId = Input::get('userId');
        //删除上次时间记录
        Info::where(['userId' => $userId])->delete();
        //插入自己最近查看记录
        $time = time();
        $info = Info::create(['userId' => $userId, 'time' => $time]);
        return response()->json(array('msg' => $userId));
    }

    /**
     * 显示活动的报名人数
     * @param $id
     */
    public function showActivityPeople($id)
    {
//        dd($id);
        if (JumpHelper::isSessionSet() || JumpHelper::isCookieSet()) {
//            $arr = Activity::calculateActivity($id);
            //获取查看的用户信息
            $sponsor = DB::table('relax_user')
                ->join('relax_activity', 'relax_user.id', '=', 'relax_activity.sponsorId')
                ->select('relax_user.*')
                ->where('relax_activity.id', '=', $id)
                ->get();
            $users = DB::table('relax_user')
                ->join('relax_activity_attend', 'relax_user.id', '=', 'relax_activity_attend.userId')
                ->join('relax_activity', 'relax_activity_attend.activityId', '=', 'relax_activity.id')
                ->select('relax_user.*')
                ->where('relax_activity.id', '=', $id)
                ->get();
//            dd($users);
            return view('other.activityPeople', ['users' => $users, 'sponsor' => $sponsor[0],'activityId'=>$id]);
        }
        return view('errors.503');
    }

    /**
     * 比较
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function compare($id){
        $arr = JumpHelper::jumpUIWith();
        if ($arr) {

            return view('myPage.compare',['user' => $arr[0],
                'activity_show' => $arr[1]]);
        } else {
            return view('errors.503');
        }

    }

    /**
     * 比较细节
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function compareDetail($id){
        $compares = DB::table('relax_sport')
            ->join('relax_friend','relax_sport.userId','=','relax_friend.friendId')
            ->join('relax_user','relax_user.id','=','relax_friend.friendId')
            ->select('relax_user.username',DB::raw('sum(relax_sport.distance) as dis'),'relax_user.id')
            ->where('relax_friend.userId','=',$id)
            ->groupBy('relax_user.id')
            ->orderBy(DB::raw('sum(relax_sport.distance)'),'desc')
            ->get();
        return response()->json($compares);
    }

    /**
     * 活动比较
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function compareActivity($id){
        $compares = DB::table('relax_sport')
            ->join('relax_activity_attend','relax_activity_attend.userId','=','relax_sport.userId')
            ->join('relax_user','relax_user.id','=','relax_activity_attend.userId')
            ->select('relax_user.username',DB::raw('sum(relax_sport.distance) as dis'))
            ->where('relax_activity_attend.activityId','=',$id)
            ->groupBy('relax_user.id')
            ->get();

        $compare = DB::table('relax_sport')
            ->join('relax_activity','relax_activity.sponsorId','=','relax_sport.userId')
            ->join('relax_user','relax_user.id','=','relax_activity.sponsorId')
            ->select('relax_user.username',DB::raw('sum(relax_sport.distance) as dis'))
            ->where('relax_activity.id','=',$id)
            ->get();
//        dd($compare);
        array_unshift($compares,$compare[0]);

        return response()->json($compares);
    }

    /**
     * 活力值比较
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function compareLevel($id){
        $compares = DB::table('relax_user')
            ->join('relax_friend','relax_user.id','=','relax_friend.friendId')
            ->select('relax_user.username','relax_user.activity','relax_','relax_user.id')
            ->where('relax_friend.userId','=',$id)
            ->orderBy(DB::raw('relax_user.activity'),'desc')
            ->limit(10)
            ->get();
        return response()->json($compares);
    }

    /**
     * 用户等级分布
     * @return \Illuminate\Http\JsonResponse
     */
    public function userLevels(){
        $levels = DB::table('relax_user')
            ->select('level',DB::raw('count(*) as number'))
            ->groupBy('level')
            ->get();
        return response()->json($levels);
    }

}