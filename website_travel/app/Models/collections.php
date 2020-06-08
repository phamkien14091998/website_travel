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
     public static function createCollection($collection_name,$data_collection,$data_collection_detail,$user_id){
        $data_collection['created_at'] = Carbon::now();
        $collections = DB::table('collections')->get();

        $data_colle='';
        
        for($i=0; $i< count($collections);$i++){
            if($collections[$i]->collection_name == $data_collection['collection_name'] && 
                $collections[$i]->user_id == $data_collection['user_id']
            ){
                return $data_colle = '';
            }
        }

        $data_colle = self::
                insertGetId($data_collection);

        // nếu địa điểm khác rỗng mới cho insert , va $data_colle !=''
        if($data_colle!='' &&  $data_collection_detail['famous_place_id_array'][0] !=""  ){
            // tạo mảng mới -> for và insert đưa nó vào table
            $data_detail=[];
            for($i=0; $i< count($data_collection_detail['famous_place_id_array']) ;$i++ ){
                $data_detail['famous_place_id']=$data_collection_detail['famous_place_id_array'][$i]; 
                $data_detail['collection_id'] = $data_colle;
                $data_d =DB::table('collection_detail')
                            ->insertGetId($data_detail);
            }
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
            'famous_places.famous_place_id',
            'collection_detail.collection_id'
            )
        ->get();

    }

    //delete collection
    public static function deleteCollection($collection_id){

        return self::where('collection_id','=',$collection_id)
                ->delete();
    }

    // get detail coolection by id
    public static function getDetailCollectionById($collection_id){
        $data = self::where('collection_id','=',$collection_id)
             ->first();
    
        return $data;
    }

     // update schedule
     public static function updateCollectionById($collection_id,$data){

        return self::where('collection_id', $collection_id)
            ->update($data);
    }
    //add place into collection
    public static function addPlaceIntoCollection($famous_place_id,$collection_id,$data_collection){
        $famous_id = (int)$famous_place_id;
        $data_detail_collection = DB::table('collection_detail')
                                ->where('collection_id',$collection_id)
                                ->get();
        $data_col = $data_collection;
        for($i=0;$i<count($data_detail_collection);$i++){
            // echo $data_detail_collection[$i]->famous_place_id;die;
            // nếu địa điểm đó chưa tồn tại rồi thì sẽ lưu thêm vào ,ngược lại không thêm vô 
            if($famous_id == $data_detail_collection[$i]->famous_place_id){
                echo "vo else";
                return 1;
            }
        }
        return  DB::table('collection_detail')->insertGetId($data_col);
    }
    // xóa địa điểm trong bộ sưu tập
    public static function deletePlaceCollection($famous_place_id,$collection_id){

        return DB::table('collection_detail')
                ->where([
                    'famous_place_id'=> $famous_place_id,
                    'collection_id'=> $collection_id
                ])
                ->delete();
    }





    
}
