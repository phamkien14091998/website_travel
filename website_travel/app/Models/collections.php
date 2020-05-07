<?php

namespace App\Models;
use DB;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class collections extends Model
{
    //
    protected $table="collections";
    
    protected $primaryKey = 'collection_id ';
    public $timestamps = false;
    protected $guarded = [];

    // protected $fillable = [ 
    //     'collection_id',
    //     'collection_name', 
    //     'user_id'
    // ];

    // create collection new
     public static function createCollection($collection_name,$data_collection,$data_collection_detail){
        $data_collection['created_at'] = Carbon::now();
        
        $data_colle = self::insertGetId($data_collection);

        // tạo mảng mới -> for và insert đưa nó vào table
        $data_detail=[];
        for($i=0; $i< count($data_collection_detail['famous_place_id_array']) ;$i++ ){
            $data_detail['famous_place_id']=$data_collection_detail['famous_place_id_array'][$i]; 
            $data_detail['collection_id'] = $data_colle;
            $data_d =DB::table('collection_detail')
                        ->insertGetId($data_detail);
        }
                        
        return $data_colle;

    }
    // lấy ra danh sách vộ sưu tập của user đang đăng nhập
    public static function getListCollectionByUser($user_id){
        
        return self::where('user_id',$user_id)
                ->select('collection_name','created_at','collection_id')
                ->get();
    } 
    // get detail collection  by id
    public static function getDetailCollection($collection_id){
        return DB::table('collection_detail')
        ->where('collection_id',$collection_id)
        ->join('famous_places','famous_places.famous_place_id','=','collection_detail.famous_place_id')
        ->join('provinces','provinces.province_id','=','famous_places.province_id')
        ->select(
            'famous_places.images',
            'famous_places.title',
            'famous_places.description',
            'famous_places.date_start',
            'famous_places.date_end',
            'provinces.province_name',
            'famous_places.famous_place_id'
            )
        ->get();

    }


    
}
