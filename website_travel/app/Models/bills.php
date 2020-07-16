<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\billdetails;
use App\Models\products;
use Illuminate\Support\Facades\Session;
use App\Services\PayPalService as PayPalSvc;
use DB;

class bills extends Model
{
    //
    protected $table="bills";
    
    protected $primaryKey = 'bill_id';
    public $timestamps = false;
    protected $guarded = [];

    // thanh toán
    public static function payment($dataPayment,$cart){
        $dataPayment['created_at'] = Carbon::now();
         
        $bill_id = bills::insertGetId($dataPayment);
        $bill_detail_id = 0;
        for($i = 0 ; $i < count($cart) ; $i++){ 
            $dataBillDetail = [
                'bill_id' => $bill_id,
                'product_id' => $cart[$i]->product_id,
                'quantity' => $cart[$i]->qty,
                'price' => $cart[$i]->price,
                'created_at' => Carbon::now(),
            ];
            $bill_detail_id = billdetails::insertGetId($dataBillDetail); 
            $quantity = DB::table('products')->select('quantity')->where('product_id',$cart[$i]->product_id)->get();
          
           $q = 100; 
           $data=[
            'quantity'=>$q
           ]; 
           $product_id=$cart[$i]->product_id;
            DB::table('products') // update lại số lượng của sản phẩm đó
            ->where('product_id',$product_id)
            ->update($data);
        }
        if($bill_id != 0 && $bill_detail_id != 0){
            // xoa bang 
            return true;
        }
        return false;
    }

    // public static function paymentPaypal($dataPayment,$cart){
    //     $dataPayment['created_at'] = Carbon::now();
    //     $bill_id = bills::insertGetId($dataPayment);
    //     $bill_detail_id = 0;
    //     for($i = 0 ; $i < count($cart) ; $i++){
    //         $dataBillDetail = [
    //             'bill_id' => $bill_id,
    //             'product_id' => $cart[$i]['id'],
    //             'quantity' => $cart[$i]['qty'],
    //             'price' => $cart[$i]['price'],
    //             'created_at' => Carbon::now(),
    //         ];
    //         $bill_detail_id = billdetails::insertGetId($dataBillDetail);
    //         $quantity = products::find($cart[$i]['id'])['quantity']; // lấy ra số lượng tồn của sản phẩm đó
    //         DB::table('products') // update lại số lượng của sản phẩm đó
    //         ->where('product_id', $cart[$i]['id'])
    //         ->update(['quantity' => ($quantity - $cart[$i]['qty'])]);
    //     }
    //     if($bill_id != 0 && $bill_detail_id != 0){
    //         Session::forget('cart.name');
    //         return true;
    //     }
    //     return false;
    // }

    public static function getAllProductByUserId($user_id){

        $data = self::where('user_id','=',$user_id)
            ->leftJoin('bill_details','bills.bill_id','=','bill_details.bill_id')
            ->leftJoin('products','products.product_id','=','bill_details.product_id')
            ->select(
                'bills.bill_id',
                'bills.created_at',
                'bills.ship_fee',
                'total',
                'products.product_name',
                'bill_details.quantity',
                'bill_details.price'
            )
            ->orderBy('bills.created_at','desc')
            ->get();
    
        return $data;
    }

    



}
?>
