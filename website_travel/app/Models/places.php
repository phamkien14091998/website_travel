<?php

namespace App\Models;
use DB;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class places extends Model
{ 
     //
     protected $table="famous_places";
    
     protected $primaryKey = 'famous_place_id';
     public $timestamps = false;
     protected $guarded = [];
 
     protected $fillable = [ 
         'title', 
         'images', 
         'description',
         'date_start',
         'date_end',
         'province_id',
         'cultural',
         'weather',
         'vehicle',
         'cuisine',
         'advice'
     ];

    //get list famous places
    public static function getListPlaces(){

        return self::leftJoin('provinces','provinces.province_id','=','famous_places.province_id')
            ->select(
                'title',
                // 'images', 
                // 'description',
                'date_start',
                'date_end',
                'province_name',
                'famous_place_id'
            )
            // ->paginate(5);
            ->get(); 
    }
    // get list provinces
    public static function getListProvince(){

        return DB::table('provinces')
            ->leftJoin('famous_places','famous_places.province_id','=','provinces.province_id')
            ->selectRaw(
                'provinces.province_id,
                province_name,
                count(famous_places.province_id) as countPlace,
                provinces.image'

            )
            ->groupBy('provinces.province_id')
            ->get();
    }
    // get detail place by id
    public static function getDetailPlace($famous_place_id){

    $data = self::where('famous_place_id','=',$famous_place_id)
        ->leftJoin('provinces','provinces.province_id','=','famous_places.province_id')
        ->select(
            'title',
            'images', 
            'description',
            'date_start',
            'date_end',
            'province_name',
            'famous_place_id',
            'famous_places.province_id',
            'cultural',
            'weather',
            'vehicle',
            'cuisine',
            'advice'
        )
        ->first();

    return $data;
    }
    // create place
    public static function createPlace($data){
        $data['created_at'] = Carbon::now();
       
        return self::insertGetId($data);
    }
    // update place
    public static function updatePlaceById($famous_place_id,$data){

        return self::where('famous_place_id', $famous_place_id)
            ->update($data);
    }
    //delete place
    public static function deletePlacetById($famous_place_id){

        return self::where('famous_place_id','=',$famous_place_id)
                ->delete();
    }
    // timf kiếm địa điểm theo id tỉnh
    public static function searchPlaceByProvivnceId($province_id) {
        
        // return 
        // self::where('famous_places.province_id','=',$province_id)
        // ->join('provinces','provinces.province_id','=','famous_places.province_id')
        // ->select(
        //     'title',
        //     'famous_place_id',
        //     'images',
        //     'description',
        //     'date_start',
        //     'date_end',
        //     'famous_places.created_at',
        //     'province_name'
        // )
        // ->get();
        return 
        self::where('famous_places.province_id','=',$province_id)
        ->leftJoin('provinces','provinces.province_id','=','famous_places.province_id')
        ->select(
            'title',
            'famous_place_id',
            'famous_places.province_id',
            'famous_places.images',
            'provinces.province_name'
        )
        ->get();
    }
    // vũ làm theo phương thức get
    public static function searchPlaceByProvivnceIdGET($province_id) {
        // return 
        // self::where('famous_places.province_id','=',$province_id)
        // ->join('provinces','provinces.province_id','=','famous_places.province_id')
        // ->select(
        //     'title',
        //     'famous_place_id',
        //     'images',
        //     'description', 
        //     'date_start',
        //     'date_end',
        //     'famous_places.created_at',
        //     'province_name'
        // )
        // ->get();
        return 
            self::where('famous_places.province_id','=',$province_id)
            ->join('provinces','provinces.province_id','=','famous_places.province_id')
            ->leftJoin('rating','rating.famous_place_id','=','famous_places.famous_place_id')
            ->select(
                DB::raw(
                    'avg(point) as avgPoint,
                    count(point) as countRating,
                    famous_places.famous_place_id,
                    famous_places.title,
                    famous_places.images,
                    famous_places.created_at,
                    description,
                    date_start,
                    date_end
                    '
                    )
            )
            ->orderBy('avgPoint', 'desc')
            ->groupBy('famous_place_id')
            ->get(); 
    
        
    }

    // get ra 8 địa điểm mới nhất của tất cả những người đăng tại trang home
     public static function getList8Provinces(){
        return DB::table('provinces')
            ->leftJoin('famous_places','famous_places.province_id','=','provinces.province_id')
            ->selectRaw(
                'provinces.province_id,
                province_name,
                count(famous_places.province_id) as countPlace,
                provinces.image'

            )
            ->groupBy('provinces.province_id')
            ->take(8)
            ->get();
    }
    // get ra 11 địa điểm mới nhất của tất cả những người đăng tại trang home
    public static function getList11Provinces(){
        return DB::table('provinces')
        ->leftJoin('famous_places','famous_places.province_id','=','provinces.province_id')
        ->selectRaw(
            'provinces.province_id,
            province_name,
            count(famous_places.province_id) as countPlace,
            provinces.image'

        )
        ->groupBy('provinces.province_id')
        ->take(11)
        ->get();
    }
    // lấy ra địa điểm by id
    public static function getPlaceByid($famous_place_id_arr){
        $array_new=[];
        for($i=0; $i< count($famous_place_id_arr) ;$i++ ){
            $data['famous_place_id']=$famous_place_id_arr[$i]; 
            $data_return =DB::table('famous_places')->where('famous_place_id',$data['famous_place_id'])
                ->select(
                'title',
                'famous_place_id'
            )
            ->get();
            // dd($data_return);die;
            array_push($array_new,$data_return[0]);
        }
        return $array_new;
    }

    public static function getDetail($famous_place_id){
        $data = self::where('famous_place_id','=',$famous_place_id)
            ->leftJoin('provinces','provinces.province_id','=','famous_places.province_id')
            ->select(
                'title',
                'images', 
                'description',
                'date_start',
                'date_end',
                'famous_place_id',
                'cultural',
                'weather',
                'vehicle',
                'cuisine',
                'advice',
                'provinces.province_name',
                'famous_places.province_id'
            )
            ->first();
        return $data;
    }
    // lấy tất cả địa điểm theo tỉnh trừ địa điểm hiện tại
    public static function searchPlaceByProvivnceIdNewPost($province_id,$famous_place_id){
        $sql= "famous_places.province_id = {$province_id} 
        AND famous_places.famous_place_id != {$famous_place_id}";
        // return 
        // self::whereRaw(
        //     $sql
        //     )
        // ->join('provinces','provinces.province_id','=','famous_places.province_id')
        // ->select(
        //     'title',
        //     'famous_place_id',
        //     'images',
        //     'description', 
        //     'date_start',
        //     'date_end',
        //     'famous_places.created_at',
        //     'province_name',
        //     'famous_places.province_id'
        // )
        // ->get();
        return 
            self::whereRaw(
                $sql
                )
            ->join('provinces','provinces.province_id','=','famous_places.province_id')
            ->leftJoin('rating','rating.famous_place_id','=','famous_places.famous_place_id')
            ->select(
                DB::raw(
                    'avg(point) as avgPoint,
                    count(point) as countRating,
                    famous_places.famous_place_id,
                    famous_places.title,
                    famous_places.images,
                    famous_places.created_at,
                    description,
                    date_start,
                    date_end,
                    province_name,
                    famous_places.province_id
                    '
                    )
            )
            ->orderBy('avgPoint', 'desc')
            ->groupBy('famous_place_id')
            ->get(); 
    } 
    // tìm kiếm địa điểm theo title
    public static function searchPlaceByTitle($title){
        $condition ='';
        $condition.="title like '%{$title}%'";
        return self::whereRaw($condition)
                ->join('provinces','provinces.province_id','=','famous_places.province_id')
                ->orderBy('famous_place_id', 'ASC')
                ->select(
                    'title',
                    'famous_place_id',
                    'images',
                    'description', 
                    'date_start',
                    'date_end',
                    'famous_places.created_at',
                    'province_name',
                    'famous_places.province_id'
                    )
                ->get();
    }
    // lấy ra top 10 place có số điểm đc đánh giá cao nhất tháng hiện tại
    public static function getTop10Place(){

        $m = getdate()['mon'];
        $y = getdate()['year'];
       
       return DB::table('famous_places')
       ->leftJoin('rating','rating.famous_place_id','=','famous_places.famous_place_id')
       ->select(  
           DB::raw(
               '
               sum(point) as sumPoint,
               rating.created_at,
               famous_places.title,
               images,
               famous_places.famous_place_id
               '
               )
       )
       ->orderBy('sumPoint', 'desc')
       ->take(10)
       ->whereDay('rating.created_at','<', '32')
       ->whereDay('rating.created_at','>', '0')
       ->whereMonth('rating.created_at', $m)
       ->whereYear('rating.created_at', $y)
       ->groupBy('famous_places.famous_place_id')
       ->get(); 
   }
   // tìm kiếm địa điểm theo tỉnh
   public static function searchPlaceByProvinId($province_id){
    $sql= "famous_places.province_id = {$province_id} ";

    return 
    self::whereRaw(
        $sql
        )
    ->leftJoin('provinces','provinces.province_id','=','famous_places.province_id')
    ->select(
        'title',
        'famous_place_id',
        'images',
        'description', 
        'date_start',
        'date_end',
        'famous_places.created_at',
        'province_name',
        'famous_places.province_id'
    )
    ->get();
    }
    // tìm kiếm địa điểm theo id tỉnh và title địa điểm
    public static function searchPlaceByTitleAndProvinId($title,$province_id){
        $condition ='';
        if(isset($title) && isset($province_id)){ 
            $condition.="title like '%{$title}%' and provinces.province_id = '$province_id'";
        }
        $data = self::leftJoin('provinces','provinces.province_id','=','famous_places.province_id')
            ->whereRaw('('.$condition.')')
            ->orderBy('famous_place_id', 'ASC')
            ->select(
                'title',
                'famous_place_id',
                'images',
                'description', 
                'date_start',
                'date_end',
                'famous_places.created_at',
                'province_name',
                'famous_places.province_id' 
            )
            ->get();
        
        return $data;
       }


}
    
