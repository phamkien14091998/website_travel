<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\products;

class ProductController extends Controller
{
    /**
     * Display a listing product
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get list product
        $data_listProduct= products::getListProduct();

        // dd($data_listProduct); // hay nay do tôi in chỗ này làm nó chạy k đc á
        // // ông xóa đi
        return  response()->json($data_listProduct);// trar về json
        
    }

    public function getListPortfolio(){
        // get list product portfolio
        $data_portfolio= products::getListPortfolio();
        return response()->json($data_portfolio,200);
    }

    public function create(Request $request)
    {   
        
        $validator = Validator::make($request->all(),[
            'product_name' => 'required|string|max:40|unique:products', 
        ]);
        if($validator->fails()){ 
            return response()->json('dữ liệu không hợp lệ',500);
        }

        $uploadPath="upload/";
        $filename='';

        $images = array();
        for($i=0 ; $i<count($_FILES['fileUpload']['name']);$i++){
            $filename = $uploadPath . date("His-d-m-Y").rand(1,1000) . $_FILES['fileUpload']['name'][$i];
            // thêm dữ liệu vô mảng mới
            array_push($images,$filename);
            // lưu hình
            $d=move_uploaded_file($_FILES['fileUpload']['tmp_name'][$i],$filename);
        } 
        // for lấy ra phần tử của mảng
        // for($i=0;$i<count($images);$i++){
        //     $data[$i]= $images[$i];
        // }

        // ghép mảng images thành chuỗi ngăn cách bởi dấu |
        $image_string='';
        $image_string=join("|",$images);
      
        $data=[
            'product_name' => $request->product_name,
            'price' => $request->price,
            'description' => $request->description,
            'quantity' => $request->quantity,
            'portfolio_id' => $request->portfolio_id,
            'images'=> $image_string,
        ]; 
       
       
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
