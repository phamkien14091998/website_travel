<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;

class products extends Model
{
    //
    protected $table="products";
    
    protected $primaryKey = 'product_id';
    public $timestamps = false;
    protected $guarded = [];

    protected $fillable = [ 
        'product_name',
        'price', 
        'description',
        'quantity',
        'portfolio_id',
        'images',
    ];
    // create product
    public static function createProduct($data){

        $data['created_at'] = Carbon::now();
        return  self::insertGetId($data);
    }
    // get list portfilio (danh sách thể loại)
    public static function getListPortfolio(){

        return DB::table('products_portfolio')
                ->get();
    }
    //get list product 
    public static function getListProduct(){

        return DB::table('products')
            ->leftJoin('products_portfolio','products_portfolio.portfolio_id','=','products.portfolio_id')
            ->select(
                'product_id',
                'portfolio_name',
                'product_name',
                'price', 
                'description',
                'quantity',
                'images'
            )
            // ->paginate(5);
            ->get(); 
    }
   // search product by product_name
   public static function searchProductByname($product_name){
    $condition ='';
    // if(isset($product_name) && $product_name !=''){
        $condition.="product_name like '%{$product_name}%'";
    // } 
    $data_product = self::whereRaw('('.$condition.')')
        ->leftJoin('products_portfolio','products_portfolio.portfolio_id','=','products.portfolio_id')
        ->orderBy('product_id', 'ASC')
        ->select(
            'product_id',
            'portfolio_name',
            'product_name',
            'price', 
            'description',
            'quantity',
            'images'
        )
        ->get();  
    return $data_product;
   }
   // search all product of product_portfolio_id
   public static function searchProductByportfolioByid($portfolio_id){
    $data_product = self::leftJoin('products_portfolio','products_portfolio.portfolio_id','=','products.portfolio_id')
    ->where('products.portfolio_id','=',$portfolio_id)
    ->orderBy('product_id', 'ASC')
    ->select(
        'product_id',
        'portfolio_name',
        'product_name',
        'price', 
        'description',
        'quantity',
        'images'
    )
    ->get();
    return $data_product;
   }
   // lấy ra sản phẩm có product_name và portfolio_id
   public static function searchProductByProNameAndPortId($product_name,$portfolio_id){
    $condition ='';
    if(isset($product_name) && isset($portfolio_id)){ 
        $condition.="product_name like '%{$product_name}%' and products.portfolio_id = '$portfolio_id'";
    }
    $data_product = self::leftJoin('products_portfolio','products_portfolio.portfolio_id','=','products.portfolio_id')
        ->whereRaw('('.$condition.')')
        ->orderBy('product_id', 'ASC')
        ->select(
            'product_id',
            'portfolio_name',
            'product_name',
            'price', 
            'description',
            'quantity',
            'images'
        )
        ->get();
    
    return $data_product;
   }

   // get detail product by id
   public static function getDetailProduct($product_id){
    $data_product = self::where('product_id','=',$product_id)
    ->leftJoin('products_portfolio','products_portfolio.portfolio_id','=','products.portfolio_id')
    ->select(
        'product_id',
        'portfolio_name',
        'product_name',
        'price', 
        'description',
        'quantity',
        'images',
        'products.portfolio_id'
    )
    ->first();
    return $data_product;
   }
   // delete product by id 
   public static function deleteProductById($product_id){
    return self::where('product_id','=',$product_id)
            ->delete();
    }
    // update product by id : UPDATE Products SET product_name=$product_name WHERE product_id=$product_id
    public static function updateProductById($product_id,$data){

        return self::where('product_id', $product_id)
            ->update($data);
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////
    // get 16 product mới nhất
    public static function getProductNew(){

        return DB::table('products')
        ->leftJoin('products_portfolio','products_portfolio.portfolio_id','=','products.portfolio_id')
        ->select(
            'product_id',
            'portfolio_name',
            'product_name',
            'price', 
            'description',
            'quantity',
            'images'
        )
        ->orderBy('product_id', 'desc')
        ->take(16)
        ->where('quantity','>','0')
        // ->paginate(5);
        ->get(); 
    }
    // timf kiếm sản phẩm theo thể loại id (những sản phẩm còn hàng)
     // search all product of product_portfolio_id
    public static function searchProductByportfolioByidConHang($portfolio_id){
        $data_product = self::leftJoin('products_portfolio','products_portfolio.portfolio_id','=','products.portfolio_id')
        ->where('products.portfolio_id','=',$portfolio_id)
        ->orderBy('product_id', 'ASC')
        ->select(
            'product_id',
            'portfolio_name',
            'product_name',
            'price', 
            'description',
            'quantity',
            'images'
        )
        ->where('quantity','>','0')
        ->get();

        return $data_product;
    }
    // lấy ra 10 sản phẩm bán chạy nhất tháng qua
    public static function getTop10(){
        $m = getdate()['mon'];
        $y = getdate()['year'];

        return DB::table('products')
            ->leftJoin('bill_details','bill_details.product_id','=','products.product_id')
            ->select(
                DB::raw(
                    '
                    sum(bill_details.quantity) as sumQuantity,
                    bill_details.created_at,
                    product_name
                    '
                )
            )
            ->orderBy('sumQuantity', 'desc')
            ->take(10)
            ->whereDay('bill_details.created_at','<', '32')
            ->whereDay('bill_details.created_at','>', '0')
            ->whereMonth('bill_details.created_at', $m)
            ->whereYear('bill_details.created_at', $y)
            ->groupBy('products.product_id')
            ->get(); 
    }
    // thống kê doanh thu từ tháng 1->12 năm 2020
    public static function getStatisticsRevenue(){
        $sql="Select Month(created_at) as 'month',Year(created_at) as 'year', Sum(total) as 'doanhThu'
        From bills
        Group by Month(created_at) order by Month(created_at) DESC";

        return DB::select($sql);
    }
    // lấy ra 16 sản phẩm bán chạy nhất từ trước tới nay
    public static function getProducRevenue(){
        return DB::table('products')
            ->leftJoin('bill_details','bill_details.product_id','=','products.product_id')
            ->select(
                DB::raw(
                    '
                    sum(bill_details.quantity) as sumBill_detail,
                    products.product_name ,
                    products.price , 
                    products.images,
                    products.quantity,
                    products.description,
                    products.product_id
                    '
                )
            )
            ->orderBy('sumBill_detail', 'desc')
            ->take(16)
            ->groupBy('products.product_id')
            ->get(); 
    }
    // thống kê toàn bộ trang home
    public static function getStatistical(){
        $countProvince = DB::table('provinces')
                    -> selectRaw(
                        '
                        count(province_id) as countProvince
                        '
                    )->get();
        $countPlace = DB::table('famous_places')
                    -> selectRaw(
                        '
                        count(famous_place_id) as countPlace
                        '
                    )->get();
        $countPost = DB::table('posts')
                    ->where('flag',1)
                    -> selectRaw(
                        '
                        count(post_id) as countPost
                        '
                    )->get();
        $countUser = DB::table('users')
                    -> selectRaw(
                        '
                        count(user_id) as countUser
                        '
                    )->get();
        $countRating = DB::table('rating')
                    -> selectRaw(
                        '
                        count(point) as countRating
                        '
                    )->get();
        
        $data = [
            $countProvince,
            $countPlace,
            $countPost,
            $countUser,
            $countRating
        ];
        return $data; 

    }


}
