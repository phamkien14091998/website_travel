<?php

namespace App\Http\Controllers;

use App\Models\bills;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class BillController extends Controller
{
    public function payment(Request $request){
        $user_id = $request->user_id;
        $cart =  Session::get('cart.name');//lấy ra giỏ hàng
        $totalMoneyOfCart = 0;//Tổng tiền sản phẩm trong giỏ hàng không tính phí ship
        for($i = 0 ; $i < count($cart) ; $i++){
            $totalMoneyOfCart += ((int)$cart[$i]['price'] * $cart[$i]['qty']);
        }

        //Xử lý trường hình thức giao hàng
        $form_of_delivery = '';
        if($request->shipfee == "0"){
            $form_of_delivery = "Miễn phí";
        } else if ($request->shipfee == "22000") {
            $form_of_delivery = "Giao trong 3 ngày";
        } else {
            $form_of_delivery = "Giao trong 1 ngày";
        }

        //Dữ liệu insert vào bảng bills
        $dataPayment=[
            "ship_fee" => $request->shipfee,
            "form_of_payment" => $request->methods,
            "note" => $request->note,
            "user_id" => $user_id,
            "form_of_delivery" => $form_of_delivery,
            "total" => $totalMoneyOfCart,
        ]; 

        //gọi models
        $payment=bills::payment($dataPayment,$cart);
        if($payment){
            return response()->json('Thanh toán thành công',200);
        } else {
            return response()->json('Thanh toán thất bại',500);
        } 
    }
    // get all products by user_id
    public function getAllProductByUserId(Request $request){
        $user_id = $request->user_id;
        $data = bills::getAllProductByUserId($user_id);
        return response()->json($data,'200');
    }
}
?>
