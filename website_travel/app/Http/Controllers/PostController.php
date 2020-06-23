<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\posts;   

class PostController extends Controller
{
    //get List Post chờ duyệt cuar user
    public function getListPost(Request $request){
        $user_id = $request->user_id;
        $data= posts::getListPost($user_id);
        if($data){   
            return response()->json($data,200);
        }
    }
    //get List 9 Post đã duyệt mới nhất cua tất cả user  
    public function getListPost9Duyet(){
        $data= posts::getListPost9Duyet();
        if($data){  
            return response()->json($data,200);
        }
    }
    //get List  Post đã duyệt mới nhất cua tất cả user
    public function getAllPostDuyet(){
        $data= posts::getAllPostDuyet();
        if($data){  
            return response()->json($data,200);
        }
    }
    //get List Post Bị quản trị viên hủy cua user
    public function getListPostHuy(Request $request){
        $user_id = $request->user_id;
 
        $data= posts::getListPostHuy($user_id);
        if($data){  
            return response()->json($data,200);
        }
    }
    //Tìm kiếm bài viết theo flag(0,1,2)
    public function getPostByFlag(Request $request){
        $user_id = $request->user_id;
 
        $bai_duyet = $request->bai_duyet;
        $bai_chua_duyet = $request->bai_chua_duyet;
        $bai_huy = $request->bai_huy;
        if($bai_duyet == 'true' && $bai_chua_duyet == 'true'){
            $bai_duyet=1;
            $bai_chua_duyet=0; 
            $data= posts::getListPostDuyetAndChua($bai_duyet,$bai_chua_duyet,$user_id);
            if($data){  
                return response()->json($data,200);
            }

        }
        if($bai_duyet == 'true' && $bai_huy == 'true'){
            $bai_duyet=1;
            $bai_huy=2; 
            $data= posts::getListPostDuyetAndHuy($bai_duyet,$bai_huy,$user_id);
            if($data){  
                return response()->json($data,200);
            }
        }
        if($bai_chua_duyet == 'true' && $bai_huy == 'true'){
            $bai_chua_duyet=0;
            $bai_huy=2; 
            $data= posts::getListPostChuaAndHuy($bai_chua_duyet,$bai_huy,$user_id);
            if($data){  
                return response()->json($data,200);
            }
        }
        if($bai_duyet == 'true' ){  
            $bai_duyet=1;
            $data= posts::getListPostDuyet($bai_duyet,$user_id);
            if($data){  
                return response()->json($data,200);
            }
        }
        if($bai_chua_duyet == 'true' ){
            $bai_chua_duyet=0; 
            $data= posts::getListPost($bai_chua_duyet,$user_id);
            if($data){  
                return response()->json($data,200);
            }
        }
        if($bai_huy == 'true'  ){ 
            $bai_huy=2;
            $data= posts::getListPostHuy($bai_huy,$user_id);
                if($data){  
                    return response()->json($data,200);
                }
        }
        
        $data= posts::getAllPost($user_id);
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
            'title' => $request->title,
            'date_start' => $request->date_start,
            'date_end' => $request->date_end,
            'duration' => $request->duration,
            'fare' => $request->fare,
            'images'=> $image_string,
            'gaits' => $request->gaits,
            'items' => $request->items,
            'home_stay'=> $request->home_stay,
            'visits' => $request->visits,
            'activitis' => $request->activitis,
            'note'=> $request->note,
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
    // get All post chưa duyệt trên trang quản trị viên
    public function getAllPostChuaDuyet(){
        $data= posts::getAllPostChuaDuyet();
        if($data){  
            return response()->json($data,200);
        }
    }
    // Admin duyệt bài hoạc hủy bài
    public function approvedOrNotApprovedPost(Request $request){
        $post_id = $request->post_id;
        $approved = $request->approved;
        $notApproved = $request->notApproved;

        $data= posts::approvedOrNotApprovedPost($post_id,$approved,$notApproved);
        if($data){
            return response()->json($data,200);
        }
        return response()->json('thất bại',500);
    }
    public function getAllPostByPlaceId(Request $request){
        if($request->famous_place_id){
            $famous_place_id = $request->famous_place_id;
            $data_search = posts::getAllPostByPlaceId($famous_place_id);
            return  response()->json($data_search,'200');
        }
    }
    public function getAllPostByProvinceId(Request $request){
        if($request->province_id){
            $province_id = $request->province_id;
            $data_search = posts::getAllPostByProvinceId($province_id);
            return  response()->json($data_search,'200');
        }
    }
    public function getTop10User(){
       
        $data = posts::getTop10User();
        if($data){
            return  response()->json($data,200);
        }
        return response()->json('khong tim thay',400);

    }
    // update viewer 
    public function updateViewer(Request $request){
        $post_id= $request->post_id;
        $viewer= $request->viewer;
       
        $data = posts::updateViewer($post_id,$viewer);
        return  response()->json($data,200);
    }
    

}
