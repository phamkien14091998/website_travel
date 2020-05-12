<?php

namespace App\Http\Controllers;

use App\Models\cart;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{

    public function addToCart($product_id){

        //Session::forget('cart');

        $product_id_int = (int)$product_id;

        $value = cart::add($product_id_int);
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

    
}