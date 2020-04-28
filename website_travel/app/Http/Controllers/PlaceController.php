<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\places;


class PlaceController extends Controller
{
    // get all places
    public function getListPlace(){

        $data= places::getListPlaces();
        if($data){  
            return response()->json($data,200);
        }
    }
    // get all provinces
    public function getListProvince(){

        $data= places::getListProvince();
        if($data){  
            return response()->json($data,200);
        }
    }

    // get detail place by id
     public function getDetailPlace(Request $request){
        $famous_place_id = $request->famous_place_id;

        $data = places::getDetailPlace($famous_place_id);
        return response()->json($data,'200');
    }
    
    // create place
    public function createPlace(Request $request){
        $validator = Validator::make($request->all(),[
            'title' => 'required|string|max:40|unique:famous_places', 
        ]);  
        if($validator->fails()){   
            return response()->json('tiêu đề không được trùng',500);
        }
        $uploadPath="upload-place/"; 
        $filename='';

        $images = array();
        for($i=0 ; $i<count($_FILES['fileUpload']['name']);$i++){
            $filename = $uploadPath . date("His-d-m-Y").rand(1,1000) . $_FILES['fileUpload']['name'][$i];
            // thêm dữ liệu vô mảng mới
            array_push($images,$filename);
            // lưu hình
            $d=move_uploaded_file($_FILES['fileUpload']['tmp_name'][$i],$filename);
        } 
        $image_string='';
        $image_string=join("|",$images);
      
        $data=[
            'title' => $request->title,
            'images'=> $image_string,
            'description' => $request->description,
            'date_start' => $request->date_start,
            'date_end' => $request->date_end,
            'province_id' => $request->province_id,
        ]; 
        $data=places::createPlace($data);
        if($data){ 
            return response()->json('Thành Công',200);
        }
        return response()->json('Thất Bại',400);
    }
    // update place
    public function updatePlaceById(Request $request)
    {
        if($request->images){
            $image_string= $request->images;
            $image_string=explode(",", $image_string);
            $image_string=join("|",$image_string);
        }
        $uploadPath="upload-place/";
        $filename='';

        $images = array();
        if(isset($_FILES['fileUpload']['name'])){
            for($i=0 ; $i<count($_FILES['fileUpload']['name']);$i++){
                $filename = $uploadPath . date("His-d-m-Y").rand(1,1000) . $_FILES['fileUpload']['name'][$i];
                // thêm dữ liệu vô mảng mới
                array_push($images,$filename);
                // lưu hình
                $d=move_uploaded_file($_FILES['fileUpload']['tmp_name'][$i],$filename);
            } 
        // ghép mảng images thành chuỗi ngăn cách bởi dấu |
            $image_string='';
            $image_string=join("|",$images);
        }
      
        $famous_place_id= $request->famous_place_id;
        $data=[
            'title' => $request->title,
            'images'=> $image_string,
            'description' => $request->description,
            'date_start' => $request->date_start,
            'date_end' => $request->date_end,
            'province_id' => $request->province_id,
        ]; 
       
        if($data){  
            $data=places::updatePlaceById($famous_place_id,$data);
            // if($data){ 
                return response()->json('Sửa Thành Công',200);
            // }
            // return response()->json('Sửa Thất Bại',400);
        }
       return response()->json('thiếu dữ liệu truyền vào',500);
    }

    // delete place
    public function deletePlace(Request $request)
    {
        $famous_place_id = $request->famous_place_id;
       
        $data = places::deletePlacetById($famous_place_id);
        if($data){
            return response()->json('xóa thành công địa điểm',200);
        }else{
            return response()->json('xóa không thành công địa điểm',400);
        }

    }


}