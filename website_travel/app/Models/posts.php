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

        // $post = self::leftJoin('users','users.user_id','=','posts.user_id')
        //     // ->leftJoin('comments','comments.post_id','=','posts.post_id') // lấy số lượng cmt ra
        //     ->leftJoin('rating','rating.post_id','=','posts.post_id')
        //     ->select(  
        //         DB::raw(
        //             'avg(point) as avgPoint,
        //             count(point) as countRating,
                    // posts.post_id,
                    // posts.title,
                    // users.user_name,
                    // users.avatar,
                    // posts.flag,
                    // images,
                    // posts.created_at
        //             '
        //             )
        //     )
        //     ->orderBy('avgPoint', 'desc')
        //     ->where('posts.flag','1') // khi flag= 1 là đã duyệt
        //     ->groupBy('post_id')
        //     ->get(); 
        // $data = [
        //     $countComment,
        //     $post
        // ];

        $d = "SELECT
                post_id,
                posts.post_id,
                posts.title,
                users.user_name,
                users.avatar,
                posts.flag,
                images,
                posts.viewer,
                posts.created_at,
                ( SELECT count(*) FROM rating WHERE rating.post_id = posts.post_id ) AS countRating,
                ( SELECT AVG( point ) FROM rating WHERE rating.post_id = posts.post_id ) AS avgPoint,
                ( SELECT count(*) FROM comments WHERE comments.post_id = posts.post_id ) AS countComment 
            FROM
                posts 
            LEFT JOIN users on users.user_id= posts.user_id
            WHERE
                posts.flag = 1
            ORDER BY
                avgPoint DESC 
            ";
        $d = DB::select($d);

        return $d;

    }
    // get list famous places của user đang chờ duyệt flag= 0
    public static function getListPost($bai_chua_duyet,$user_id){
        return self::leftJoin('users','users.user_id','=','posts.user_id')
            ->select(
                'users.user_name',
                'posts.title',
                'posts.flag',
                'posts.post_id'
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
                'posts.flag',
                'posts.post_id'
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
                'posts.flag',
                'posts.post_id'
            )
            ->where([
                'posts.flag'=>$bai_huy,
                'users.user_id' => $user_id
            ]) // khi flag= 2 là hủy
            // ->paginate(5);
            ->get(); 
    }
    public static function getListPostDuyetAndChua($bai_duyet,$bai_chua_duyet,$user_id){
        
        $sql="users.user_id = {$user_id} AND (posts.flag = 0 OR posts.flag = 1 ) ";
        return self::leftJoin('users','users.user_id','=','posts.user_id')
            ->select(
                'users.user_name',
                'posts.title',
                'posts.flag',
                'posts.post_id'
            )
            ->whereRaw($sql) 
            ->get(); 
    }
    public static function getListPostDuyetAndHuy($bai_duyet,$bai_huy,$user_id){
        $sql="(posts.flag = {$bai_duyet} OR posts.flag = {$bai_huy}  )AND  users.user_id = {$user_id}";
        return self::leftJoin('users','users.user_id','=','posts.user_id')
            ->select(
                'users.user_name',
                'posts.title',
                'posts.flag',
                'posts.post_id'
            )
            ->whereRaw($sql) 
            ->get(); 
    }
    public static function getListPostChuaAndHuy($bai_chua_duyet,$bai_huy,$user_id){
        $sql="(posts.flag = {$bai_chua_duyet} OR posts.flag = {$bai_huy}  )AND  users.user_id = {$user_id}";
        return self::leftJoin('users','users.user_id','=','posts.user_id')
            ->select(
                'users.user_name',
                'posts.title',
                'posts.flag',
                'posts.post_id'
            )
            ->whereRaw($sql) 
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
        // $sql="select count(c.comment_id) as count,post_id from posts p left join comments c on p.post_id = c.post_id  group by post_id";

        // return self::leftJoin('users','users.user_id','=','posts.user_id')
        //     // ->leftJoin('comments','comments.post_id','=','posts.post_id') // lấy số lượng cmt ra
        //     ->leftJoin('rating','rating.post_id','=','posts.post_id')
        //     ->select(  
        //         DB::raw(
        //             'avg(point) as avgPoint,
        //             count(point) as countRating,
        //             posts.post_id,
        //             posts.title,
        //             users.user_name,
        //             users.avatar,
        //             posts.flag,
        //             images,
        //             posts.created_at
        //             '
        //         )
        //     )
        //     ->orderBy('avgPoint', 'desc')
        //     ->take(9)
        //     ->where('posts.flag','1') // khi flag= 1 là đã duyệt
        //     ->groupBy('post_id')
        //     ->get(); 

        $d = "SELECT
            post_id,
            posts.post_id,
            posts.title,
            users.user_name,
            users.avatar,
            posts.flag,
            images,
            posts.viewer,
            posts.created_at,
            ( SELECT count(*) FROM rating WHERE rating.post_id = posts.post_id ) AS countRating,
            ( SELECT AVG( point ) FROM rating WHERE rating.post_id = posts.post_id ) AS avgPoint,
            ( SELECT count(*) FROM comments WHERE comments.post_id = posts.post_id ) AS countComment 
        FROM
            posts 
        LEFT JOIN users on users.user_id= posts.user_id
        WHERE
            posts.flag = 1
        ORDER BY
            avgPoint DESC 
        LIMIT 9	
        ";
    $d = DB::select($d);

    return $d;

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
                'famous_places.description',
                'viewer'
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
        // $data = self::where('posts.famous_place_id','=',$famous_place_id)
        //     ->leftJoin('famous_places','famous_places.famous_place_id','=','posts.famous_place_id')
        //     ->leftJoin('users','users.user_id','=','posts.user_id')
        //     ->leftJoin('provinces','famous_places.province_id','=','provinces.province_id')
        //     ->select(
        //         'posts.title as post_title',
        //         'duration',
        //         'posts.date_start',
        //         'posts.date_end',
        //         'fare',
        //         'posts.images',
        //         'flag',
        //         'famous_places.title as place_title',
        //         'users.user_name',
        //         'posts.post_id',
        //         'provinces.province_name',
        //         'gaits',
        //         'home_stay',
        //         'visits',
        //         'activitis',
        //         'note',
        //         'items',
        //         'users.avatar',
        //         'posts.created_at',
        //         'famous_places.description'
        //     )
        //     ->where([
        //         'posts.flag'=>1,
        //         ])
            // ->get(); 
        // return $data;


        $d = "SELECT
                posts.post_id,
                posts.title,
                users.user_name,
                users.avatar,
                posts.flag,
                posts.images,
                posts.viewer,
                posts.created_at,
                ( SELECT count(*) FROM rating WHERE rating.post_id = posts.post_id ) AS countRating,
                ( SELECT AVG( point ) FROM rating WHERE rating.post_id = posts.post_id ) AS avgPoint,
                ( SELECT count(*) FROM comments WHERE comments.post_id = posts.post_id ) AS countComment 
            FROM
                posts
                LEFT JOIN users ON users.user_id = posts.user_id
                LEFT JOIN famous_places ON famous_places.famous_place_id = posts.famous_place_id 
            WHERE
                posts.famous_place_id = {$famous_place_id} 
            ORDER BY
            avgPoint DESC 
        ";
        $d = DB::select($d);

    return $d;



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
    // lấy ra top 10 user có số điểm đc đánh giá cao nhất
    public static function getTop10User(){

         $m = getdate()['mon']-1;
         $y = getdate()['year'];

        

        return DB::table('users')
        ->leftJoin('posts','posts.user_id','=','users.user_id')
        ->leftJoin('rating','rating.post_id','=','posts.post_id')
        ->select(  
            DB::raw(
                '
                sum(point) as sumPoint,
                users.user_name,
                rating.created_at,
                users.avatar
                '
                )
        )
        ->orderBy('sumPoint', 'desc')
        ->take(10)
        ->whereRaw('
        posts.flag = 1 
        '
        ) // khi flag= 1 là đã duyệt
        ->whereDay('rating.created_at','<', '32')
        ->whereDay('rating.created_at','>', '0')
        ->whereMonth('rating.created_at', $m)
        ->whereYear('rating.created_at', $y)
        ->groupBy('users.user_id')
        ->get(); 
    }
    // update viewer
    public static function updateViewer($post_id,$viewer){
        $data = [
            'viewer' => $viewer
        ];
        $updateViewerPost = self::where('post_id', $post_id)
            ->update($data);
    }


}