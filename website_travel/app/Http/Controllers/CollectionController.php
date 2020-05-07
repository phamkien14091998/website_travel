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
        $validator = Validator::make($request->all(),[
            'collection_name' => 'required|string|max:40|unique:collections', 
        ]);  
        if($validator->fails()){   
            return response()->json('Tên Bộ Sưu Tập không được trùng',500);
        }
        
        $collection_name = $request->collection_name;
      
        $data_collection=[
            'collection_name' => $request->collection_name,
            'user_id' => $request->user_id
        ]; 
        $famous_place_id_array = explode(',', $request->famous_place_id_array);
        $data_collection_detail=[
            'famous_place_id_array' => $famous_place_id_array
        ];
        
        $data=collections::createCollection($collection_name,$data_collection,$data_collection_detail);

        if($data){ 
            return response()->json('Thành Công',200);
        }
        return response()->json('Thất Bại',400);

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
     
 


}
