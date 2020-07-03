<?php

namespace App\Models;
use DB;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class comments extends Model
{
    //
    protected $table="comments";   
    
    protected $primaryKey = 'comment_id';
    public $timestamps = false;
    protected $guarded = [];
    protected $fillable = [ 
        'content',
        'user_id',
        'post_id'
    ];
    // lấy tất cả comment của bài viết 
    public static function getAllCommentByPostId($post_id){
        
        return self::where('post_id',$post_id)
        ->leftJoin('users','users.user_id','=','comments.user_id')
        ->select(
            'comments.content',
            'comments.user_id',
            'comments.post_id',
            'comments.comment_id',
            'users.user_name',
            'comments.created_at',
            'users.avatar'
        )
        ->orderBy('comment_id','desc')
        ->get(); 
    }
    // thêm comment theo bài viết và user đăng nhập
    public static function createCommentByPostId($user_id,$data_comment){

        $data_comment['created_at'] = Carbon::now();
        $data=  self::insertGetId($data_comment);
        return self::leftJoin('users','users.user_id','=','comments.user_id')
            ->where('comments.user_id',$user_id)
            ->select(
                'comments.content',
                'comments.user_id',
                'comments.post_id',
                'comments.comment_id',
                'users.user_name',
                'comments.created_at',
                'users.avatar'
            )
            ->orderBy('comment_id','desc')
            ->first();
    }

    public static function deleteComment($comment_id){
        return self::where('comment_id','=',$comment_id)
        ->delete();
    }
    // update comment by id
    public static function updateCommentByid($comment_id,$content,$post_id){
        $data = [
            'content' => $content
        ];
        $updateComment = DB::table('comments')
            ->where('comment_id', $comment_id)
            ->update($data);

        return self::where('post_id',$post_id)
            ->leftJoin('users','users.user_id','=','comments.user_id')
            ->select(
                'comments.content',
                'comments.user_id',
                'comments.post_id',
                'comments.comment_id',
                'users.user_name',
                'comments.created_at',
                'users.avatar'
            )
            ->orderBy('comment_id','desc')
            ->get(); 
    }
    // thêm comment chuyến đi theo user đăng nhập
    public static function createCommentByTripId($user_id,$data_comment){

        $data_comment['created_at'] = Carbon::now();
        $data=  self::insertGetId($data_comment);
        $a= self::leftJoin('users','users.user_id','=','comments.user_id')
            ->where('comments.user_id',$user_id)
            ->select(
                'comments.content',
                'comments.user_id',
                'comments.trip_id',
                'comments.comment_id',
                'users.user_name',
                'comments.created_at'
            )
            ->orderBy('comment_id','desc')
            ->first();
        return $a;
    }
    // lấy tất cả comment của lịch trình 
    public static function getAllCommentByTripId($trip_id){
        
        return self::where('trip_id',$trip_id)
        ->leftJoin('users','users.user_id','=','comments.user_id')
        ->select(
            'comments.content',
            'comments.user_id',
            'comments.trip_id',
            'comments.comment_id',
            'users.user_name',
            'comments.created_at'
        )
        ->orderBy('comment_id','desc')
        ->get(); 
    }

    // update comment by trip_id
    public static function updateCommentByidTrip($comment_id,$content,$trip_id){
        $data = [
            'content' => $content
        ];
        $updateComment = DB::table('comments')
            ->where('comment_id', $comment_id)
            ->update($data);

        return self::where('trip_id',$trip_id)
            ->leftJoin('users','users.user_id','=','comments.user_id')
            ->select(
                'comments.content',
                'comments.user_id',
                'comments.trip_id',
                'comments.comment_id',
                'users.user_name',
                'comments.created_at'
            )
            ->orderBy('comment_id','desc')
            ->get(); 
    }

}
 