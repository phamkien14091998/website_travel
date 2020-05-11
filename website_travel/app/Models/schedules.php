<?php

namespace App\Models;
use DB;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class schedules extends Model
{
      //
    protected $table="trips";
    
    protected $primaryKey = 'trip_id';
    public $timestamps = false;
    protected $guarded = [];
  
    protected $fillable = [ 
        'trip_name', 
        'description', 
        'day_start',
        'day_end',
        'user_id'
      ];
 
    // lấy ra danh sách vehicle
    public static function getListVehicle(){

        return DB::table('vehicles')
                ->select(
                    'title',
                    'vehicle_id',
                    'description'
                )
                ->get();
    }
    // tạo lịch trình
    public static function createSchedule($dataDetail_trip,$data_trip){
        $data_trip['created_at'] = Carbon::now();

    $data_trip = self::insertGetId($data_trip);
    $tes=count($dataDetail_trip);
   
    for($i=0; $i < count($dataDetail_trip);$i++){
        $dataDetail_trip[$i]['trip_id']=$data_trip;

        $detail=DB::table('trip_details')
        ->insertGetId($dataDetail_trip[$i]);

        }   

    }

    // lấy ra danh sách lịch trình của user đang đăng nhập
    public static function getListScheduleByUser($user_id){
        
        return self::where('user_id',$user_id)
                ->select('trip_name','created_at','description','trip_id','day_start','day_end')
                ->orderBy('trip_id', 'desc')
                ->get();
    } 
    // get detail schedule  by id
    public static function getDetailSchedule($trip_id){
        
        return DB::table('trip_details')
        ->where('trip_details.trip_id',$trip_id)
        ->join('famous_places','famous_places.famous_place_id','=','trip_details.famous_place_id')
        ->join('provinces','provinces.province_id','=','famous_places.province_id')
        ->join('trips','trips.trip_id','=','trip_details.trip_id')
        ->select(
            'famous_places.images',
            'famous_places.title',
            'famous_places.description',
            'famous_places.date_start',
            'famous_places.date_end',
            'provinces.province_name',
            'famous_places.famous_place_id',
            'trip_details.time_to',
            'trip_details.time_stay',
            'trip_details.note',
            'trip_details.vehicle',
            'trips.trip_name'
            )
        ->get();

    }

     // update schedule
     public static function updateScheduleById($trip_id,$data){

        return self::where('trip_id', $trip_id)
            ->update($data);
    }
    //delete schedule
    public static function deleteScheduleById($trip_id){

        return self::where('trip_id','=',$trip_id)
                ->delete();
    }

    // get detail lich trình by id (bảng trips)
    // get detail product by id
   public static function getDetailTrips($trip_id){
    $data_schedule = self::where('trip_id','=',$trip_id)
    ->first();

    return $data_schedule;
   }

 
}
 