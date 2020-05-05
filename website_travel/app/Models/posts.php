<?php

namespace App\Models;
use DB;

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
    public static function getAllPostDuyet(){
        return DB::table('posts')
        ->leftJoin('famous_places','famous_places.famous_place_id','=','posts.famous_place_id')
            ->leftJoin('users','users.user_id','=','posts.user_id')
            ->leftJoin('provinces','famous_places.province_id','=','provinces.province_id')
            ->select(
                'posts.title as post_title',
                'duration',
                'posts.date_start',
                'posts.date_end',
                'fare',
                'posts.images',
                'flag',
                'famous_places.title as place_title',
                'users.user_name',
                'posts.post_id',
                'provinces.province_name',
                'gaits',
                'home_stay',
                'visits',
                'activitis',
                'note',
                'items',
                'users.avatar',
                'posts.created_at',
                'famous_places.description'
            )
            ->where([
                'posts.flag'=>1,
                ]) // khi flag= 0 là chưa duyệt
            // ->paginate(5);
            ->get(); 
    }

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
                'posts.flag',
                'posts.post_id'
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
                'images',
                'posts.post_id'
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
        ->leftJoin('provinces','famous_places.province_id','=','provinces.province_id')
        ->select(
            'posts.title as post_title',
            'duration',
            'posts.date_start',
            'posts.date_end',
            'fare',
            'posts.images',
            'flag',
            'famous_places.title as place_title',
            'users.user_name',
            'posts.post_id',
            'provinces.province_name',
            'gaits',
            'home_stay',
            'visits',
            'activitis',
            'note',
            'items',
            'users.avatar',
            'posts.created_at',
            'famous_places.description'
        )
        ->first();
    return $data;
    }

    // create post
    public static function createPost($data){

        $data['created_at'] = Carbon::now();
        $data['updated_at'] = Carbon::now();
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
    // get all bài viết chưa duyệt trang Admin
    public static function getAllPostChuaDuyet(){

        return self::leftJoin('users','users.user_id','=','posts.user_id')
        ->select(  
            'users.user_name',
            'posts.title',
            'posts.flag',
            'posts.created_at',
            'images',
            'posts.post_id'
        )
        ->orderBy('post_id', 'desc')
        ->where('posts.flag','0') 
        ->get(); 
    }

    // trang admin : phê duyêt bài viết
    public static function approvedOrNotApprovedPost($post_id,$approved,$notApproved){
        if(isset($approved)){
            return self::where('post_id',$post_id)
            ->update(['flag'=>1]); 
        }else if(isset($notApproved)){
            return self::where('post_id',$post_id)
            ->update(['flag'=>2]); 
        }
    }

    // get detail place by id
    public static function getAllPostByPlaceId($famous_place_id){
        $data = self::where('posts.famous_place_id','=',$famous_place_id)
            ->leftJoin('famous_places','famous_places.famous_place_id','=','posts.famous_place_id')
            ->leftJoin('users','users.user_id','=','posts.user_id')
            ->leftJoin('provinces','famous_places.province_id','=','provinces.province_id')
            ->select(
                'posts.title as post_title',
                'duration',
                'posts.date_start',
                'posts.date_end',
                'fare',
                'posts.images',
                'flag',
                'famous_places.title as place_title',
                'users.user_name',
                'posts.post_id',
                'provinces.province_name',
                'gaits',
                'home_stay',
                'visits',
                'activitis',
                'note',
                'items',
                'users.avatar',
                'posts.created_at',
                'famous_places.description'
            )
            ->where([
                'posts.flag'=>1,
                ])
            ->get(); 
        return $data;
        }

    // get all post by province id 
    public static function getAllPostByProvinceId($province_id){
        return DB::table('provinces')
            ->leftJoin('famous_places','famous_places.province_id','=','provinces.province_id')
            ->leftJoin('posts','famous_places.province_id','=','provinces.province_id')
            //->leftJoin('users','users.user_id','=','posts.user_id')
            ->select(
            )
            ->where([
                'posts.flag'=>1,
                'famous_places.province_id'=>$province_id,
                ]) // khi flag= 0 là chưa duyệt
            // ->paginate(5);
            ->get(); 
    }
}