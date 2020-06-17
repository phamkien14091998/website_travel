<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- <title>Laravel</title> -->
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

        <!-- Styles -->
        <style>
          
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">

            <div class="content" style="background-color: #968f8f;">
                <div class="title m-b-md"  style="width: 68%;
                    height: 350px;
                    background-color: #ffff;
                    margin-left: 155px;">
                    <!-- Laravel --> 
                    <h1 style="text-align: center ;padding-top: 15px; color:red ; 
                                padding-top: 20px; border-bottom: 1px solid;">
                    THÔNG BÁO MUA SẢN PHẨM THÀNH CÔNG</h1>
                    @if(isset($cart))
                       
                        <span style="padding-top: 10px;padding-left:10px" >
                            <b>Tổng tiền : {{$totalMoneyOfCart}} Đ</b>  
                        </span>

                        <div class="inner" style="height: 200px;overflow-x: scroll;">
                        <table style="border 1px solid black">
                            <thead>
                                <tr>
                                    <th>Tên sản phẩm</th>
                                    <th>Số lượng</th>
                                    <th>Đơn giá</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cart as $cart)
                                    <tr>
                                        <td>{{$cart['name']}}</td>
                                        <td>{{$cart['qty']}}</td>
                                        <td>{{$cart['price']}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                    <br>
                    <div class="row col-md-12 tex-center">
                                <span>Đây là thư tự động từ hệ thống. Vui lòng không trả lời email này. </span>
                                        <br> 
                                <span>Nếu có bất kỳ thắc mắc hay cần giúp đỡ hãy liên hệ website của chúng tôi hoạc sdt : 0968692487 để được giải quyết</span>
                    </div>
                </div>

                
            </div>

        </div>
    </body>
</html>
