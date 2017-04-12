<?php
/**
 * Created by PhpStorm.
 * User: 董轶波
 * Date: 2016/10/27 0027
 * Time: 上午 11:07
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

/**
 * 评论模型
 * Class Comment
 * @package App
 */
class Comment extends Model {

    protected $table='relax_comment';

    //设置是否自动设置时间值 create_at,update_at,delete_at,默认为true
    public $timestamps=true;

    //指定允许批量赋值的字段
    protected $fillable=['commentId','blogId','userId','created_at','updated_at','content'];

    //指定不允许批量赋值的字段
    protected $guarded=[];

    /**
     * 设置为Unix时间戳，是已经格式化好的
     * @return int
     */
    protected function getDateFormat(){
        return time();
    }

    /**
     * 取消格式化，保持Unix时间戳，便于自主实现格式化
     * @param mixed $val
     * @return mixed
     */
    protected function asDateTime($val){
        return $val;
    }
}