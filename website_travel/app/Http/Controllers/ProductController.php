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
    public function index(Request $request)
    {  
        //get list product
        $data_listProduct= products::getListProduct();

        return  response()->json($data_listProduct);// trar về json
        
    }
    //tìm kiếm theo product_name hoạc portfolio_id
    public function searchProductbyNameOrPortfolioId(Request $request){
        if($request->product_name && $request->portfolio_id){ 
            $product_name = $request->product_name;
            $portfolio_id = $request->portfolio_id;
            
            $data_product = products::searchProductByProNameAndPortId($product_name,$portfolio_id);
    
            return  response()->json($data_product,'200');
        }
        if($request->product_name){
            $product_name = $request->product_name;
            $data_product_search = products::searchProductByname($product_name);
    
            return  response()->json($data_product_search,'200');
        }
        if($request->portfolio_id){
            $portfolio_id = $request->portfolio_id;
            $data_product_search = products::searchProductByportfolioByid($portfolio_id);
    
            return  response()->json($data_product_search,'200');
        }
        
        
        //get list product
        $data_listProduct= products::getListProduct();

        return  response()->json($data_listProduct);// trar về json

    }
    // get list thể loại sản phẩm
    public function getListPortfolio(){
        // get list product portfolio
        $data_portfolio= products::getListPortfolio();
        return response()->json($data_portfolio,200);
    }
    // get chi tiết sản phẩm theo id
    public function getDetailProduct(Request $request){
        $product_id = $request->product_id;

        $data_product = products::getDetailProduct($product_id);
        return response()->json($data_product,'200');
    }
    // thêm sản phẩm
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

    public function delete(Request $request)
    {
        //delete product
        $product_id = $request->product_id;
       
        $data = products::deleteProductById($product_id);
        if($data){
            return response()->json('xóa thành công sản phẩm',200);
        }else{
            return response()->json('không tìm thấy sản phẩm',400);
        }

    }

    public function updateProductById(Request $request)
    {

        if($request->images){
            $image_string= $request->images;
            $image_string=explode(",", $image_string);
            $image_string=join("|",$image_string);
        }
        // update product tên có thể k sửa
        // $validator = Validator::make($request->all(),[
        //     'product_name' => 'required|string|max:40|unique:products', 
        // ]);
        // if($validator->fails()){  
        //     return response()->json('dữ liệu không hợp lệ',500);
        // }
        

        $uploadPath="upload/";
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
      
        $product_id= $request->product_id;
        $data=[
            'product_name' => $request->product_name,
            'price' => $request->price,
            'description' => $request->description,
            'quantity' => $request->quantity,
            'portfolio_id' => $request->portfolio_id,
            'images'=> $image_string,
        ]; 
       
        if($data){  
            $data_product=products::updateProductById($product_id,$data);
            // if($data_product){ 
                return response()->json('Sửa Thành Công',200);
            // }
            // return response()->json('Sửa Thất Bại',400);
        }
       return response()->json('Thiêu dữ liệu truyền vào',500);

    }

    /////////////////////////////////////////////////////////////

    // Trang bán sản phẩm
    public function getProductNew(){
        //get list product new
        $data_listProduct= products::getProductNew();

        return  response()->json($data_listProduct);
    }
    // xem danh sách sản phẩm theo thể loại id
    public function searchByPortfolio_id(Request $request){
        $portfolio_id = $request->portfolio_id;

        $data= products::searchProductByportfolioByidConHang($portfolio_id);
        if($data){ 
            return response()->json($data,200);
        }
        return response()->json('không tìm thấy sản phẩm nào',400);
    }
    // lấy ra top 10 product
    public function getTop10(){
        $data= products::getTop10();
        return response()->json($data,200);
    }
    // thống kê doanh thu từ tháng 1->12 năm 2020
    public function getStatisticsRevenue(){
        $data= products::getStatisticsRevenue();
        return response()->json($data,200);
    }
      // Trang bán sản phẩm (lấy ra 16 sản phẩm bán chạy nhất)
      public function getProducRevenue(){
        //get list product new
        $data_listProduct= products::getProducRevenue();

        return  response()->json($data_listProduct);
    }
    // tim kiem san pham theo ten
    public function searchProductbyName(Request $request){
        $product_name = $request->product_name;
        $data = products::searchProductbyName($product_name);
        return response()->json($data);
    }
    // thống kê toàn bộ trang home

    public function getStatistical(){
        $data= products::getStatistical();

        return  response()->json($data);
    }


}
