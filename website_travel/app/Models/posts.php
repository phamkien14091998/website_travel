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
        'location', 
        'duration',
        'uptime',
        'fare',
        'images',
        'flag',
        'famous_place_id',
        'user_id'

    ];

    // get list famous places đang chờ duyệt flag= 0
    public static function getListPost(){
        return self::leftJoin('users','users.user_id','=','posts.user_id')
            ->select(
                'users.user_name',
                'posts.title',
                'flag'
            )
            ->where('flag','0') // khi flag= 0 là chưa duyệt
            // ->paginate(5);
            ->get(); 
    }
    // get list famous places đã được duyệt flag= 1
    public static function getListPostDuyet(){
        return self::leftJoin('users','users.user_id','=','posts.user_id')
            ->select(
                'users.user_name',
                'posts.title',
                'duration',
                'uptime',
                'flag'
            )
            ->where('flag','1') // khi flag= 1 là đã duyệt
            // ->paginate(5);
            ->get(); 
    }
    // get list famous places đã bị hủy flag= 3 
    // (lấy ra cho member xem bài đã bị hủy)
    public static function getListPostHuy(){
        return self::leftJoin('users','users.user_id','=','posts.user_id')
            ->select(
                'users.user_name',
                'posts.title',
                'duration',
                'uptime',
                'flag'
            )
            ->where('flag','3') // khi flag= 3 là hủy
            // ->paginate(5);
            ->get(); 
    }

    // get detail place by id
    public static function getDetailPost($post_id){

    $data = self::where('post_id','=',$post_id)
        ->leftJoin('famous_places','famous_places.famous_place_id','=','posts.famous_place_id')
        ->leftJoin('users','users.user_id','=','posts.user_id')
        ->select(
            'posts.title',
            'location', 
            'duration',
            'uptime',
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