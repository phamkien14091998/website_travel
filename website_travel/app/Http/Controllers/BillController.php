<?php

namespace App\Http\Controllers;

use App\Models\bills;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Services\PayPalService as PayPalSvc;

class BillController extends Controller
{
    private $paypalSvc;

    public function __construct(PayPalSvc $paypalSvc)
    {
        //parent::__construct();

        $this->paypalSvc = $paypalSvc;
    }

    public function paymentPaypal(Request $request)
    {
        $user_id = $request->user_id;
        $cart =  Session::get('cart.name');//lấy ra giỏ hàng  

        //Xử lý trường hình thức giao hàng
        $form_of_delivery = '';
        if($request->shipfee == "0"){
            $form_of_delivery = "Miễn phí";
        } else if ($request->shipfee == "22000") {
            $form_of_delivery = "Giao trong 3 ngày";
        } else {
            $form_of_delivery = "Giao trong 1 ngày";
        }

        //Tổng tiền giỏ hàng
        $totalMoneyOfCart = 0;
        for($i = 0 ; $i < count($cart) ; $i++){
            $totalMoneyOfCart += ((int)$cart[$i]['price'] * $cart[$i]['qty']);
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

        Session::put('dataPayment',$dataPayment);

        $dataBillDetail = [];

        for($i = 0 ; $i < count($cart) ; $i++){
            $dataBillDetail[$i] = [
                'product_name' => $cart[$i]['name'],
                'quantity' => $cart[$i]['qty'],
                'price' => round((int)$cart[$i]['price'] / 23143, 2)
            ];
        }

        $dataBillDetail[count($cart)] = [
            'product_name' => 'Ship Fee',
            'quantity' => 1,
            'price' => round((int)$request->shipfee / 23143, 2)
        ];

        $transactionDescription = $dataPayment['note'];

        $paypalCheckoutUrl = $this->paypalSvc
                                  // ->setCurrency('eur')
                                  ->setReturnUrl(url('api/paypal/status'))
                                  // ->setCancelUrl(url('paypal/status'))
                                  ->setItem($dataBillDetail)
                                  // ->setItem($data[0])
                                  // ->setItem($data[1])
                                  ->createPayment($transactionDescription);
        if ($paypalCheckoutUrl) {
            //return redirect($paypalCheckoutUrl);
            return ['url' => $paypalCheckoutUrl];
        } else {
            dd(['Error']);
        }
    }

    // chuyển hướng trang sau khi thanh toán thành công!
    public function statusBill()
    {
        $paymentStatus = $this->paypalSvc->getPaymentStatus();
        if($paymentStatus->state == "approved"){
            // đoan jreturn này là khi thnah toán xong nó trả về trang này
            // mà t k biết sao để nó hiện thông báo, chỉ đưa về đc trang này thôi
            // khi về trang này thì 
            // chỗnayfoong lamfsao truyền thêm thông báo nha
            // khoan , chỗ này là trả về luôn tại đây hả
            // thnah toán xong nó reddire về trang này, xong từ trang này nó mưới gọi hàm insert

            // return response()->redirectTo('http://localhost:4200/product');
            return response()->redirectTo('https://app-deploy-a1b74.web.app/product');
            

        } else {
            // return response()->redirectTo('http://localhost:4200');
            return response()->redirectTo('https://app-deploy-a1b74.web.app');
        }        
    }

    public function paymentPayPalInsertData(Request $request){
        $cart = Session::get('cart.name');
        $dataPayment = Session::get('dataPayment');
        $checkPayment = bills::payment($dataPayment,$cart);

        //Tổng tiền giỏ hàng
        $totalMoneyOfCart = 0;
        for($i = 0 ; $i < count($cart) ; $i++){
            $totalMoneyOfCart += ((int)$cart[$i]['price'] * $cart[$i]['qty']);
        }
        $email = $request->email;
        if($checkPayment){
            \Mail::send('payment',['cart'=>$cart , 'totalMoneyOfCart'=>$totalMoneyOfCart],function($message) use($email){
                $message->from('phamkien14091998@gmail.com','WebsiteTravel');
                $message->to($email)->subject('Thông Báo Mua Sản Phẩm !');
            });
            return response()->json('Thanh toán thành công',200);
        } else {
            return response()->json('Thanh toán thất bại',500);
        } 
    }

    //thanh toán bằng tiền mặt
    public function paymentCash(Request $request){
        $user_id = $request->user_id;
        $cart =  Session::get('cart.name');//lấy ra giỏ hàng cart này là mảng sản phẩm nó mua
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

        $email = $request->email;
        //gọi models
        
        $payment=bills::payment($dataPayment,$cart);
        if($payment){
            \Mail::send('payment',['cart'=>$cart , 'totalMoneyOfCart'=>$totalMoneyOfCart],function($message) use($email){
                $message->from('phamkien14091998@gmail.com','WebsiteTravel');
                $message->to($email)->subject('Thông Báo Mua Sản Phẩm !');
            });
            return response()->json('Thanh toán thành công',200);
        } else {
            return response()->json('Thanh toán thất bại',500);
        } 
    }

    // get danh sách tất cả các đơn hàng đã thanh toán by user_id
    public function getAllProductByUserId(Request $request){
        $user_id = $request->user_id;
        $data = bills::getAllProductByUserId($user_id);
        return response()->json($data,'200');
    }
}
?>
