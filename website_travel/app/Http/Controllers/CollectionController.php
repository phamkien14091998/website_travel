<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\Models\collections;

class CollectionController extends Controller 
{
    // create collection new 
    public function create(Request $request){
        // $validator = Validator::make($request->all(),[
        //     'collection_name' => 'required|string|max:40|unique:collections'
        // ]);  
        // if($validator->fails()){   
        //     return response()->json('Tên Bộ Sưu Tập không được trùng',500);
        // }
        
        $collection_name = $request->collection_name;
        $user_id = $request->user_id;
      
        $data_collection=[
            'collection_name' => $request->collection_name,
            'user_id' => $request->user_id
        ]; 
        $famous_place_id_array = explode(',', $request->famous_place_id_array);
        $data_collection_detail=[
            'famous_place_id_array' => $famous_place_id_array
        ];
        
        $data=collections::createCollection($collection_name,$data_collection,$data_collection_detail,$user_id);

       
        if($data !=''){  

            return response()->json('Thành Công',200);
        } else if($data == ''){
            return response()->json('Ten BST da ton tai',400);
        }
        

    }

    // get list collection by user
    public function getListCollectionByUser(Request $request){
        $user_id = $request->all()[0];
        $data = collections::getListCollectionByUser($user_id);
        if($data){
            return response()->json($data,200);
        }
        return response()->json('Không có dữ liệu',500);
    }
    // get detail collecion by id
    public function getDetailCollection(Request $request){
        $collection_id = $request->collection_id;

        $data= collections::getDetailCollection($collection_id);
        if($data){ 
            return response()->json($data,200);
        }
        return response()->json('Thất Bại',400);

    }
    // delete collection
    public function deleteCollection(Request $request)
    {
        $collection_id = $request->collection_id;
        
        $data = collections::deleteCollection($collection_id);
        if($data){
            return response()->json('xóa thành công bộ sưu tập',200);
        }else{
            return response()->json('xóa thất bại',500);
         }
 
     }

    // update collection
    public function updateCollectionById(Request $request)
    { 
          $collection_id= $request->collection_id;
          $data=[
             'collection_name' => $request->collection_name
          ]; 
          
        $data=collections::updateCollectionById($collection_id,$data);
         if($data){   
             return response()->json('Sửa Thành Công',200);
         }
         return response()->json('Sửa Thất Bại',400);
    }

     // get detail colelction by id 
     public function getDetailCollectionById(Request $request){
        $collection_id = $request->collection_id;

        $data = collections::getDetailCollectionById($collection_id);
        return response()->json($data,'200');
     }
     //  add place into collection 
    public function addPlaceIntoCollection(Request $request){
        $data_collection= $request->all();
        $collection_id = $request->collection_id;
        $famous_place_id = $request->famous_place_id;
        $data=collections::addPlaceIntoCollection($famous_place_id,$collection_id,$data_collection);

       
        if($data == 0){  
            return response()->json('Thành Công',200);
        }
        else if($data == 1){
            return response()->json('Thất Bại',500);
        }
       
    }

    // delete place trong collection(xoa trong bảng collection_detail)
    public function deletePlaceCollection(Request $request)
    {
        $famous_place_id = $request->famous_place_id;
        $collection_id = $request->collection_id;
        
        $data = collections::deletePlaceCollection($famous_place_id,$collection_id);
        if($data){
            return response()->json('xóa thành công địa điểm trong bộ sưu tập',200);
        }else{
            return response()->json('xóa thất bại địa điểm',500);
         }
 
     }


 


}
