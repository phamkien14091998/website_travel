<?php

namespace App\Models;
use DB;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class places extends Model
{
     //
     protected $table="famous_places";
    
     protected $primaryKey = 'famous_place_id ';
     public $timestamps = false;
     protected $guarded = [];
 
     protected $fillable = [ 
         'title',
         'images', 
         'description',
         'date_start',
         'date_end',
         'province_id',
 
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
            ->select(
                'province_id',
                'province_name',
                'image'
            )
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
            'famous_places.province_id'
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
        
        return 
        self::where('famous_places.province_id','=',$province_id)
        ->join('provinces','provinces.province_id','=','famous_places.province_id')
        ->select(
            'title',
            'famous_place_id',
            'images',
            'description',
            'date_start',
            'date_end',
            'famous_places.created_at',
            'province_name'
        )
        ->get();
    }

    // get ra 8 địa điểm mới nhất của tất cả những người đăng tại trang home
     public static function getList8Provinces(){
        return DB::table('provinces')
            ->select(
                'province_id',
                'province_name',
                'image'
            )
            ->take(8)
            ->get();
    }

        // get ra 8 địa điểm mới nhất của tất cả những người đăng tại trang home
        public static function getList11Provinces(){
            return DB::table('provinces')
                ->select(
                    'province_id',
                    'province_name',
                    'image'
                )
                ->take(11)
                ->get();
        }


}
    
