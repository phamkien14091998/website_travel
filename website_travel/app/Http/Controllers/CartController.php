<?php

namespace App\Http\Controllers;

use App\Models\cart;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function addToCart(Request $request){

        //Session::forget('cart');
        $user_id = $request->user_id;
        $product_id_int = $request->product_id;

        $value = cart::add($product_id_int,$user_id);
        if($value){
            return response()->json($value,200);
        }
        return response()->json('Không có dữ liệu',500);
    }

    public function getAllProductForCart(){
        $value = cart::getAllProductForCart();
        if($value){
            return response()->json($value,200);
        }
        return null;
    }

    public function deleteProductFromCart($product_id){
        $value = cart::deleteProductFromCart($product_id);
        if($value){
            return response()->json($value,200);
        } 
        return response()->json('Không có dữ liệu',500);
    }

    public function getTotalCart(){
        $value = cart::getTotalCart();
        if($value){
            return response()->json($value,200);
        }
        return null;
    }

    public function tangSoLuongSP($id){
        $value = cart::tangSoLuongSP($id);
        if($value){
            return response()->json($value,200);
        }
        return null;
    }

    public function giamSoLuongSP($id){
        $value = cart::giamSoLuongSP($id);
        if($value){
            return response()->json($value,200);
        }
        return null;
    }

    public function getSoLuongTonKho(){
        $value = cart::getSoLuongTonKho();
        if($value){
            return response()->json($value,200);
        }
        return null;
    }
}