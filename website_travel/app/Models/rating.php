<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;

class rating extends Model
{
    //
    protected $table="rating";
    
    public $timestamps = false;
    protected $guarded = [];

    protected $fillable = [ 
        'point', 
        'post_id', 
        'user_id'
    ];

    // bài post
    public static function createRating($data_rating,$user_id,$post_id){

        $data_rating['created_at'] = Carbon::now();

        self::insertGetId($data_rating);
        // khi thêm xong thì trả về cái vừa thêm mới 
        return self::leftJoin('users','users.user_id','=','rating.user_id')
        ->where([
            'rating.user_id'=>$user_id,
            'rating.post_id'=> $post_id
        ])
        ->select(
            'users.user_name',
            'rating.point',
            'rating.post_id',
            'rating.created_at',
            'users.avatar'
        )
        ->orderBy('created_at','desc')
        ->first();
    }

    // kiểm tra xem người dùng đã đánh giá bài viết hay chưa
    public static function checkUserRatingPost($user_id,$post_id){
        $check = DB::table('rating')->get();
        for($i=0;$i < count($check);$i++){
            if($post_id == $check[$i]->post_id && $user_id == $check[$i]->user_id ){
                
                return $data = $check[$i];

            }
        }

    }

    // update đánh giá của user cho bài viết đó
    public static function updateRating($user_id,$post_id,$point){
        $data_rating = [
            'point' => $point,
            'updated_at' => Carbon::now()
        ];

        self::where(
            [
                'post_id'=> $post_id,
                'user_id'=> $user_id
            ])
            ->update($data_rating);
        
        return self::leftJoin('users','users.user_id','=','rating.user_id')
            ->where([
                'rating.user_id'=>$user_id,
                'rating.post_id'=> $post_id
            ])
            ->select(
                'users.user_name',
                'rating.point',
                'rating.post_id',
                'rating.created_at',
                'users.avatar'
            )
            ->orderBy('created_at','desc')
            ->first();
    }
    // lấy ra tất cả đánh giá của bài viết theo post_id
    public static function getAllRatingPost($post_id){
        
        return self::leftJoin('users','users.user_id','=','rating.user_id')
                ->where('post_id',$post_id)
                ->select(
                    'users.user_name',
                    'rating.point',
                    'rating.post_id',
                    'rating.created_at',
                    'users.avatar'
                )
                ->orderBy('created_at','desc')
                ->get();
    }

    // place
    public static function createRatingPlace($data_rating,$user_id,$famous_place_id){

        $data_rating['created_at'] = Carbon::now();

        self::insertGetId($data_rating);
        // khi thêm xong thì trả về cái vừa thêm mới 
        return self::leftJoin('users','users.user_id','=','rating.user_id')
        ->where([
            'rating.user_id'=>$user_id,
            'rating.famous_place_id'=> $famous_place_id
        ])
        ->select(
            'users.user_name',
            'rating.point',
            'rating.famous_place_id',
            'rating.created_at',
            'users.avatar'
        )
        ->orderBy('created_at','desc')
        ->first();
    }

    // kiểm tra xem người dùng đã đánh giá bài viết hay chưa
    public static function checkUserRatingPlace($user_id,$famous_place_id){
        $check = DB::table('rating')->get();
        for($i=0;$i < count($check);$i++){
            if($famous_place_id == $check[$i]->famous_place_id && $user_id == $check[$i]->user_id ){
                
                return $data = $check[$i];

            }
        }

    }

    // update đánh giá của user cho bài viết đó
    public static function updateRatingPlace($user_id,$famous_place_id,$point){
        $data_rating = [
            'point' => $point,
            'updated_at' => Carbon::now()
        ];

        self::where(
            [
                'famous_place_id'=> $famous_place_id,
                'user_id'=> $user_id
            ])
            ->update($data_rating);
        
        return self::leftJoin('users','users.user_id','=','rating.user_id')
            ->where([
                'rating.user_id'=>$user_id,
                'rating.famous_place_id'=> $famous_place_id
            ])
            ->select(
                'users.user_name',
                'rating.point',
                'rating.famous_place_id',
                'rating.created_at',
                'users.avatar'
            )
            ->orderBy('created_at','desc')
            ->first();
    }
    // lấy ra tất cả đánh giá của bài viết theo post_id
    public static function getAllRatingPlace($famous_place_id){
        
        return self::leftJoin('users','users.user_id','=','rating.user_id')
                ->where('famous_place_id',$famous_place_id)
                ->select(
                    'users.user_name',
                    'rating.point',
                    'rating.famous_place_id',
                    'rating.created_at',
                    'users.avatar'
                )
                ->orderBy('created_at','desc')
                ->get();
    }


} 
