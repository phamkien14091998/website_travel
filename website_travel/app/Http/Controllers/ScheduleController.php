<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\schedules;

use Mail;
use App\Mail\MailSend;
 
class ScheduleController extends Controller
{
     // get list vehicles
     public function getListVehicle(){

        $data= schedules::getListVehicle();
        if($data){  
            return response()->json($data,200);
        }
    }
    // create schedule
    public function create(Request $request){ 
        $validator = Validator::make($request->all(),[
            'trip_name' => 'required|string|max:40|unique:trips', 
        ]);  
        if($validator->fails()){   
            return response()->json('tên lịch trình không được trùng',500);
        }

        // $place_id_luu_arr = $request->place_id_luu_arr;
        $dataDetail_trip = $request->dataDetail_trip;

        $trip_name = $request->trip_name;
        $description = $request->description; 
        $day_start = $request->day_start;
        $day_end = $request->day_end;
        $user_id = $request->user_id;
        $email = $request->email;
        $friends = $request->friends;
        $friends_arr = $request->friends_arr;

        $data_trip =[
            'trip_name' => $trip_name,
            'description' => $description,
            'day_start' => $day_start,
            'day_end' => $day_end,
            'user_id'=>$user_id,
            'friends'=>$friends
        ];

        $data= schedules::createSchedule($dataDetail_trip,$data_trip,$friends_arr);

        \Mail::send('welcome',['data_trip'=>$data_trip],function($message) use($email){
            $message->from('phamkien14091998@gmail.com','WebsiteTravel');
            $message->to($email)->subject('Thông Báo Tạo Lịch Trình!');
        });
        if($data){  
            return response()->json($data,200);
        }


    }

    // lấy danh sách lịch trinh theo user
    public function getListScheduleByUser(Request $request){
       
        $user_id = $request->user_id;
        $data = schedules::getListScheduleByUser($user_id);
        if($data){
            return response()->json($data,200);
        }
        return response()->json('Không có dữ liệu',500);
    }
    // get detail schedule by id
    public function getDetailSchedule(Request $request){
        $trip_id = $request->trip_id;
        

        $data= schedules::getDetailSchedule($trip_id);
        if($data){ 
            return response()->json($data,200);
        }
        return response()->json('Thất Bại',400);

    }

     // update place
     public function updateScheduleById(Request $request)
     { 
         $trip_id= $request->trip_id;
         $data=[
            'trip_name' => $request->trip_name,
            'description' => $request->description,
            'day_start' => $request->day_start,
            'day_end' => $request->day_end
         ]; 
         
    $data=schedules::updateScheduleById($trip_id,$data);
        if($data){   
            return response()->json('Sửa Thành Công',200);
        }
        return response()->json('Sửa Thất Bại',400);
    }
 
    // delete schedule
    public function deleteSchedule(Request $request)
    {
        $trip_id = $request->trip_id;
        
        $data = schedules::deleteScheduleById($trip_id);
        if($data){
            return response()->json('xóa thành công lịch trình',200);
        }else{
            return response()->json('xóa thất bại',500);
         }
  
     }
     // get detail trips 
     public function getDetailTrips(Request $request){
        $trip_id = $request->trip_id;

        $data_schedule = schedules::getDetailTrips($trip_id);
        return response()->json($data_schedule,'200');
     }

     // delete schedule-detail
     public function deleteScheduleDetail(Request $request)
     {
         $trip_detail_id = $request->trip_detail_id;
        
         $data = schedules::deleteScheduleDetail($trip_detail_id);
         if($data){
             return response()->json('xóa thành công chi tiết lịch trình',200);
         }else{
             return response()->json('xóa thất bại',500);
         }
 
     }

    // get detail trips 
    public function getDetailScheduleDetail(Request $request){
        $trip_detail_id = $request->trip_detail_id;

        $data = schedules::getDetailScheduleDetail($trip_detail_id);
        return response()->json($data,'200');
    }

      // update schedule-detail
      public function updateScheduleDetail(Request $request)
      { 
          $trip_detail_id= $request->trip_detail_id;
          $data=[
             'time_to' => $request->time_to,
             'time_stay' => $request->time_stay,
             'note' => $request->note,
             'vehicle' => $request->vehicle
          ]; 
          
          
     $data=schedules::updateScheduleDetail($trip_detail_id,$data);
        //  if($data){     
             return response()->json('Sửa Thành Công',200);
        //  }
        //  return response()->json('Sửa Thất Bại',400);
     }

    public function getAllUser(Request $request){
        $user_id = $request->user_id;

        $data = schedules::getAllUser($user_id);
        return response()->json($data,200);
    }
    
    public function getUserNameById(Request $request){
        $arr_user_id = $request->arr_user_id;
        
        $data = schedules::getUserNameById($arr_user_id);
        return response()->json($data,200);
    }
    public function getInvateSchedule(Request $request){
        $user_id = $request->user_id;
        
        $data = schedules::getInvateSchedule($user_id);
        return response()->json($data,200);
    }
    public function getUserByTripId(Request $request){
        $trip_id = $request->trip_id;
        
        $data = schedules::getUserByTripId($trip_id);
        return response()->json($data,200);
    }
    // get user tạo lịch trình theo trip_id
    public function getUserCreateByTripId(Request $request){
        $trip_id = $request->trip_id;
        
        $data = schedules::getUserCreateByTripId($trip_id);
        return response()->json($data,200);
    }
    

}
