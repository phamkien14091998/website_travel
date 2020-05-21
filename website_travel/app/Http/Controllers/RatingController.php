<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\rating;


class RatingController extends Controller
{
    // thêm đán giá của user cho bài viết
    public function createRating(Request $request){
        $data = $request->all();
        $user_id = $request->user_id;
        $post_id=$request->post_id;

        if($data){
            $data_rating = rating::createRating($data,$user_id,$post_id);
            return response()->json($data_rating,200);
        }
        return response()->json('bắt buộc nhập',400);

    }

    // kiểm tra xem user đang đăng nhập đã đánh giá bài viết đó hay là chưa
    public function checkUserRatingPost(Request $request){
        $user_id = $request->user_id;
        $post_id = $request->post_id;

        $data= rating::checkUserRatingPost($user_id,$post_id);
        if($data){
           
            return response()->json($data,200);
        }
        return response()->json(0,200);

    } 

    // sửa đánh giá của user cho bài viết
    public function  updateRating(Request $request){
        $data = $request->all();

        $user_id = $request->user_id;
        $post_id = $request->post_id;
        $point = $request->point;

        if( $data){
            $data_rating = rating::updateRating($user_id,$post_id,$point);
            return response()->json($data_rating,200);
        }
        return response()->json('bắt buộc chọn sao trước khi gửi',400);

    }
    // lấy ra tất cả đánh giá của bài post đó
    public function getAllRatingPost(Request $request){
        $post_id = $request->post_id;

        $data= rating::getAllRatingPost($post_id);
        
        if($data){  
            return response()->json($data,200);
        }
    }

    // địa điểm
     // thêm đán giá của user cho bài viết
     public function createRatingPlace(Request $request){
        $data = $request->all();
        $user_id = $request->user_id;
        $famous_place_id=$request->famous_place_id;

        if($data){
            $data_rating = rating::createRatingPlace($data,$user_id,$famous_place_id);
            return response()->json($data_rating,200);
        }
        return response()->json('bắt buộc nhập',400);

    }

    // kiểm tra xem user đang đăng nhập đã đánh giá bài viết đó hay là chưa
    public function checkUserRatingPlace(Request $request){
        $user_id = $request->user_id;
        $famous_place_id = $request->famous_place_id;

        $data= rating::checkUserRatingPlace($user_id,$famous_place_id);
        if($data){
           
            return response()->json($data,200);
        }
        return response()->json(0,200);

    } 

    // sửa đánh giá của user cho bài viết
    public function  updateRatingPlace(Request $request){
        $data = $request->all();

        $user_id = $request->user_id;
        $famous_place_id = $request->famous_place_id;
        $point = $request->point;

        if( $data){
            $data_rating = rating::updateRatingPlace($user_id,$famous_place_id,$point);
            return response()->json($data_rating,200);
        }
        return response()->json('bắt buộc chọn sao trước khi gửi',400);

    }
    // lấy ra tất cả đánh giá của bài post đó
    public function getAllRatingPlace(Request $request){
        $famous_place_id = $request->famous_place_id;

        $data= rating::getAllRatingPlace($famous_place_id);
        
        if($data){  
            return response()->json($data,200);
        }
    }



}
