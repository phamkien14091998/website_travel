<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\products;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get list product
    }

    public function getListPortfolio(){
        // get list product portfolio
        $data_portfolio= products::getListPortfolio();
        return response()->json($data_portfolio,200);
    }

    public function create(Request $request)
    {
        $image_1='';
        $image_2='';
        $image_3=''; 
        // if($_FILES['fileUpload']['name'][0] && 
        //     $_FILES['fileUpload']['name'][1] &&  
        //     $_FILES['fileUpload']['name'][2] )
        // {
            $image_1= $_FILES['fileUpload']['name'][0];
            $image_2= $_FILES['fileUpload']['name'][1];
            $image_3= $_FILES['fileUpload']['name'][2];
        // }
        // if($_FILES['fileUpload']['name'][0] && $_FILES['fileUpload']['name'][1])
        // {  
        //     $image_1= $_FILES['fileUpload']['name'][0]; 
        //     $image_2= $_FILES['fileUpload']['name'][1];
            
           
        // } 
        // if($_FILES['fileUpload']['name'][0] )
        // {
        //     $image_1= $_FILES['fileUpload']['name'][0]; 
        //     $image_2= '';
        //     $image_3='';
        // } 
       
        $validator = Validator::make($request->all(),[
            'product_name' => 'required|string|max:40|unique:products', 
        ]);
        if($validator->fails()){ 
            return response()->json('dữ liệu không hợp lệ',400);
        }
        $data=[
            'product_name' => $request->product_name,
            'price' => $request->price,
            'description' => $request->description,
            'quantity' => $request->quantity,
            'portfolio_id' => $request->portfolio_id,
            'image_1'=>$image_1,
            'image_2'=> $image_2,
            'image_3'=>$image_3,
        ]; 
        $uploadPath="upload/";
        $filename='';

        for($i=0 ; $i<count($_FILES['fileUpload']['name']);$i++){
            $filename = $_FILES['fileUpload']['name'][$i];
            $image =$uploadPath . $_FILES['fileUpload']['name'][$i];

            $d1=move_uploaded_file($_FILES['fileUpload']['tmp_name'][$i],$image);

        }
        if($data){ 
            $data_product=products::createProduct($data);
            if($data_product){ 
                return response()->json('Thành Công',200);
            }
            return response()->json('Thất Bại',400);
        }
       return response()->json('Thiêu dữ liệu truyền vào',500);



    }

    public function delete($id)
    {
        //delete product
    }

    public function update(Request $request, $id)
    {
        //update product

    }

}
