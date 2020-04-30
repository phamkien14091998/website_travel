<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\posts;

class PostController extends Controller
{
    //get List Post chờ duyệt
    public function getListPost(){

        $data= posts::getListPost();
        if($data){  
            return response()->json($data,200);
        }
    }
    //get List Post đã duyệt
    public function getListPostDuyet(){

        $data= posts::getListPostDuyet();
        if($data){  
            return response()->json($data,200);
        }
    }
    //get List Post Bị quản trị viên hủy
    public function getListPostHuy(){

        $data= posts::getListPostHuy();
        if($data){  
            return response()->json($data,200);
        }
    }

    //Tìm kiếm bài viết theo flag(0,1,2)
    public function getPostByFlag(Request $request){
        $bai_duyet = $request->bai_duyet;
        $bai_chua_duyet = $request->bai_chua_duyet;
        $bai_huy = $request->bai_huy;
        if($bai_duyet){ 
            $data= posts::getListPostDuyet();
            if($data){  
                return response()->json($data,200);
            }
        }
        if($bai_chua_duyet){
            $data= posts::getListPost();
            if($data){  
                return response()->json($data,200);
            }
        }
        if($bai_huy){
            $data= posts::getListPostHuy();
            if($data){  
                return response()->json($data,200);
            }
        }
        $data= posts::getAllPost();
            if($data){  
                return response()->json($data,200);
            }
    }

    // get detail post by id
    public function getDetailPost(Request $request){
        $post_id = $request->post_id;

        $data = posts::getDetailPost($post_id);
        return response()->json($data,'200');
    }

    // delete post
    public function delete(Request $request)
    {
        $post_id = $request->post_id;
       
        $data = posts::deletePostById($post_id);
        if($data){
            return response()->json('xóa thành bài viết',200);
        }else{
            return response()->json('xóa thất bại',400);
        }

    }

    // thêm sản phẩm
    public function create(Request $request)
    {   
     
        $validator = Validator::make($request->all(),[
            'title' => 'required|string|max:100|unique:posts', 
        ]);  
        if($validator->fails()){   
            return response()->json('dữ liệu không hợp lệ',500);
        }
               
        $uploadPath="upload-post/";
        $filename='';

        $images = array();
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
      
        $data=[
            'title' => $request->title,
            'date_start' => $request->date_start,
            'date_end' => $request->date_end,
            'duration' => $request->duration,
            'fare' => $request->fare,
            'images'=> $image_string,
            'famous_place_id' => $request->famous_place_id,
            'user_id' => $request->user_id,
            'gaits' => $request->gaits,
            'items' => $request->items,
            'home_stay'=> $request->home_stay,
            'visits' => $request->visits,
            'activitis' => $request->activitis,
            'note'=> $request->note,
        ]; 
       
        // if($data){  
            $data_post=posts::createPost($data);
            if($data_post){ 
                return response()->json('Thêm Thành Công',200);
            }
            return response()->json('Thêm Thất Bại',400);
    //     }
    //    return response()->json('Thiêu dữ liệu truyền vào',500);
    }

    public function updatePostById(Request $request)
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
        

        $uploadPath="upload-post/";
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
      
        $post_id= $request->post_id;
        $data=[
            // 'product_name' => $request->product_name,
            // 'price' => $request->price,
            // 'description' => $request->description,
            // 'quantity' => $request->quantity,
            // 'portfolio_id' => $request->portfolio_id,
            // 'images'=> $image_string,
        ]; 
       
        if($data){  
            $data_post=posts::updatePostById($post_id,$data);
            // if($data_post){ 
                return response()->json('Sửa Thành Công',200);
            // }
            // return response()->json('Sửa Thất Bại',400);
        }
       return response()->json('Thiêu dữ liệu truyền vào',500);

    }

}
