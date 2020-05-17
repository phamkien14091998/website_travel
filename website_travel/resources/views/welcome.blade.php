<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- <title>Laravel</title> -->
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
          
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content" style="background-color: #968f8f;">
                <div class="title m-b-md"  style="width: 68%;
                    height: 350px;
                    background-color: #ffff;
                    margin-left: 155px;">
                    <!-- Laravel --> 
                    <h1 style="text-align: center ;padding-top: 15px; color:red ; 
                                padding-top: 20px; border-bottom: 1px solid;">
                    THÔNG BÁO TẠO LỊCH TRÌNH THÀNH CÔNG</h1>
                    @if(isset($data_trip))
                        <h2 style="padding-top: 15px; padding-left:10px" >
                            Tên Lịch trình : {{$data_trip['trip_name']}}
                        </h2>
                        <br>
                        <span style="padding-top: 10px;padding-left:10px" >
                            <b>Thời gian bắt đầu chuyến đi </b>: {{$data_trip['day_start']}}
                        </span>
                        <br>
                        <span style="padding-top: 10px;padding-left:10px" *ngIf="$data_trip">
                            <b>Thời gian kết thúc </b>: {{$data_trip['day_end']}}
                        </span>
                        <br>
                        <span style="padding-top: 10px;padding-left:10px" *ngIf="$data_trip">
                            <b>Mô tả</b> : {{$data_trip['description']}}
                        </span>
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
