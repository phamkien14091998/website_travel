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
    public static function createSchedule($dataDetail_trip,$data_trip,$friends_arr){
        $data_trip['created_at'] = Carbon::now();

    $data_trip = self::insertGetId($data_trip);
    $tes=count($dataDetail_trip);
  
    for($i=0; $i < count($dataDetail_trip);$i++){
        $dataDetail_trip[$i]['trip_id']=$data_trip;

        $detail=DB::table('trip_details')
        ->insertGetId($dataDetail_trip[$i]);

    }   
    // insert table friends
    $f = [];
    for($i=0; $i < count($friends_arr);$i++){
        $f['trip_id']=$data_trip;
        $f['user_id']=$friends_arr[$i];

        $detail=DB::table('friends')
        ->insertGetId($f);
    }   

    }

    // lấy ra danh sách lịch trình của user đang đăng nhập
    public static function getListScheduleByUser($user_id){
        
        return self::where('trips.user_id',$user_id)
                ->leftJoin('users','users.user_id','=','trips.user_id')
                ->select('trip_name','trips.created_at','trips.description','trips.trip_id','day_start','day_end','friends','users.user_name')
                ->orderBy('trips.trip_id', 'desc')
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
            'trip_details.trip_detail_id',
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
    //delete schedule-detail
    public static function deleteScheduleDetail($trip_detail_id){

        return DB::table('trip_details')->where('trip_detail_id','=',$trip_detail_id)
                ->delete();
    }
     // update schedule-detail
     public static function updateScheduleDetail($trip_detail_id,$data){

        return DB::table('trip_details')->where('trip_detail_id', $trip_detail_id)
            ->update($data);
    }
    // xem chi tiết schedule-detail
    public static function getDetailScheduleDetail($trip_detail_id){
        $data = DB::table('trip_details')->where('trip_detail_id','=',$trip_detail_id)
        ->first();
    
        return $data;
    }
    // get all user
    public static function getAllUser($user_id){
        $sql="select * from users where user_id != {$user_id} and role=0 ";
        return DB::select($sql);
    }
    public static function getUserNameById($arr_user_id){
        $users = DB::table('users')
                    ->whereIn('user_id', $arr_user_id)
                    ->select('user_name')
                    ->get();
        $array_old =array();
        for($i =0 ;$i< count($users); $i++){
            array_push($array_old, $users[$i]->user_name);
        }

        return $array_old;
    }
    public static function getInvateSchedule($user_id){
        $sql= "select *, trips.created_at from trips  
        join friends on friends.trip_id = trips.trip_id 
        where friends.user_id = {$user_id} order by trips.trip_id";
        return DB::select($sql);
    }
    public static function getUserByTripId($trip_id){
        $sql= "SELECT users.user_name,friends.user_id,users.avatar FROM friends LEFT JOIN users ON friends.user_id = users.user_id where trip_id={$trip_id}";
        return DB::select($sql);
    }
    public static function getUserCreateByTripId($trip_id){
        $sql= "SELECT users.user_name,trips.user_id,users.avatar FROM trips LEFT JOIN users ON trips.user_id = users.user_id where trip_id={$trip_id}";
        return DB::select($sql);
    }

 
}
 