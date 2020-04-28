<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        'main_image',
        'flag',
        'famous_place_id',
        'user_id'

    ];

//get list famous places chưa được duyệt
    public static function getListPost(){
        return self::leftJoin('famous_places','famous_places.famous_place_id','=','posts.famous_place_id')
            ->leftJoin('users','users.user_id','=','posts.user_id')
            ->select(
                'users.user_name',
                'posts.title'
            )
            ->where('flag','0') // khi flag= 0 là chưa duyệt
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
            'main_image',
            'flag',
            'famous_places.title',
            'users.user_name'
        )
        ->first();
    return $data;
    }



}
