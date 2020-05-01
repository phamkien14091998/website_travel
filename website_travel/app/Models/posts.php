<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class posts extends Model
{
    //
    protected $table="posts";   
    
    protected $primaryKey = 'post_id';
    public $timestamps = false;
    protected $guarded = [];

    protected $fillable = [ 
        'title',
        'duration',
        'date_start',
        'date_end',
        'fare',
        'images',
        'flag',
        'famous_place_id',
        'user_id',
        'gaits',
        'items',
        'home_stay',
        'visits',
        'activitis',
        'note'
    ];

    // get list famous places của user đang chờ duyệt flag= 0
    public static function getListPost($bai_chua_duyet,$user_id){
        return self::leftJoin('users','users.user_id','=','posts.user_id')
            ->select(
                'users.user_name',
                'posts.title',
                'posts.flag'
            )
            ->where([
                'posts.flag'=>$bai_chua_duyet,
                'users.user_id' => $user_id
                ]) // khi flag= 0 là chưa duyệt
            // ->paginate(5);
            ->get(); 
    }
    // get list famous places của user đã được duyệt flag= 1
    public static function getListPostDuyet($bai_duyet,$user_id){
        return self::leftJoin('users','users.user_id','=','posts.user_id')
            ->select(  
                'users.user_name',
                'posts.title',
                'posts.flag'
            )
            ->where([
                'posts.flag'=>$bai_duyet,
                'users.user_id' => $user_id
            ]) // khi flag= 1 là đã duyệt
            // ->paginate(5);
            ->get(); 
    }
    // get list famous places của user đã bị hủy flag= 2
    // (lấy ra cho member xem bài đã bị hủy)
    public static function getListPostHuy($bai_huy,$user_id){
        return self::leftJoin('users','users.user_id','=','posts.user_id')
            ->select(
                'users.user_name',
                'posts.title',
                'posts.flag'
            )
            ->where([
                'posts.flag'=>$bai_huy,
                'users.user_id' => $user_id
            ]) // khi flag= 2 là hủy
            // ->paginate(5);
            ->get(); 
    }
    
    // get all post của user đó
    public static function getAllPost($user_id){
        return self::leftJoin('users','users.user_id','=','posts.user_id')
            ->select(
                'users.user_name',
                'posts.title',
                'posts.flag'
            )
            ->where('users.user_id' , $user_id)
            ->get(); 
    }

    // lấy ra 9 bài viết được duyệt mới nhất
    public static function getListPost9Duyet(){
        return self::leftJoin('users','users.user_id','=','posts.user_id')
            ->select(  
                'users.user_name',
                'posts.title',
                'posts.flag',
                'posts.created_at',
                'images'
            )
            ->orderBy('post_id', 'desc')
            ->take(9)
            ->where('posts.flag','1') // khi flag= 1 là đã duyệt
            ->get(); 
    }

    // get detail place by id
    public static function getDetailPost($post_id){

    $data = self::where('post_id','=',$post_id)
        ->leftJoin('famous_places','famous_places.famous_place_id','=','posts.famous_place_id')
        ->leftJoin('users','users.user_id','=','posts.user_id')
        ->select(
            'posts.title',
            'duration',
            'date_start',
            'date_end',
            'fare',
            'posts.images',
            'flag',
            'famous_places.title',
            'users.user_name'
        )
        ->first();
    return $data;
    }

    // create post
    public static function createPost($data){

        $data['created_at'] = Carbon::now();
        return  self::insertGetId($data);
    }
    // update post by id
    public static function updatePostById($post_id,$data){

        $data['updated_at'] = Carbon::now();
        return self::where('post_id', $post_id)
            ->update($data);
    }
     // delete post by id 
   public static function deletePostById($post_id){

    return self::where('post_id','=',$post_id)
            ->delete();
    }



}