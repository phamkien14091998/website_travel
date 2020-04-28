<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        // $data=[
        //     [
        //         'user_name' => 'Kien Admin',
        //         'email' => 'kienadmin@gmail.com',
        //         'password' => '$2y$10$uFH/4L7itJlD3cKJKgQRKeafDRptTfGOrgmdiLu.4baLoO8/ojJJe',
        //         'full_name' => 'Phạm Duy KienAdmin',
        //         'avatar' => 'kienadmin.PNG',
        //         'date_of_birth' => '1998-09-14',
        //         'gender' => '1',
        //         'hometown' => 'Ninh Bình',
        //         'hobbies' => 'Đá bóng với đá cầu nhảy dây bắn bi trốn tìm',
        //         'role' => '1',
        //     ],
        //     [
        //         'user_name' => 'Vu Admin',
        //         'email' => 'vuadmin@gmail.com',
        //         'password' => '$2y$10$uFH/4L7itJlD3cKJKgQRKeafDRptTfGOrgmdiLu.4baLoO8/ojJJe',
        //         'full_name' => 'Phan Cong Nhat VuAdmin',
        //         'avatar' => 'vuadmin.PNG',
        //         'date_of_birth' => '1998-07-20',
        //         'gender' => '1',
        //         'hometown' => 'Huế',
        //         'hobbies' => 'Tenis cầu lông',
        //         'role' => '1',
        //     ],
            
        // ];
        // DB::table('users')->insert($data);

        // $data_provinces = [
        //     [
        //         'province_name'=>'An Giang'
        //     ],
        //     [
        //         'province_name'=>'Bà Rịa – Vũng Tàu'
        //     ],
        //     [
        //         'province_name'=>'Bắc Giang'
        //     ],
        //     [
        //         'province_name'=>'Bắc Kạn'
        //     ],
        //     [
        //         'province_name'=>'Bạc Liêu'
        //     ],
        //     [
        //         'province_name'=>'Bắc Ninh'
        //     ],
        //     [
        //         'province_name'=>'Bến Tre'
        //     ],
        //     [
        //         'province_name'=>'Bình Định'
        //     ],
        //     [
        //         'province_name'=>'Bình Dương'
        //     ],
        //     [
        //         'province_name'=>'Bình Phước'
        //     ],
        //     [
        //         'province_name'=>'Bình Thuận'
        //     ],
        //     [
        //         'province_name'=>'Cà Mau'
        //     ],
        //     [
        //         'province_name'=>'Cần Thơ'
        //     ],
        //     [
        //         'province_name'=>'Cao Bằng'
        //     ],
        //     [
        //         'province_name'=>'Đà Nẵng'
        //     ],
        //     [
        //         'province_name'=>'Đắk Lắk'
        //     ],
        //     [
        //         'province_name'=>'Đắk Nông'
        //     ],
        //     [
        //         'province_name'=>'Điện Biên'
        //     ],
        //     [
        //         'province_name'=>'Đồng Nai'
        //     ],
        //     [
        //         'province_name'=>'Đồng Tháp'
        //     ],
        //     [
        //         'province_name'=>'Gia Lai'
        //     ],
        //     [
        //         'province_name'=>'Hà Giang'
        //     ],
        //     [
        //         'province_name'=>'Hà Nam'
        //     ],
        //     [
        //         'province_name'=>'Hà Nội'
        //     ],
        //     [
        //         'province_name'=>'Hà Tĩnh'
        //     ],
        //     [
        //         'province_name'=>'Hải Dương'
        //     ],
        //     [
        //         'province_name'=>'Hải Phòng'
        //     ],
        //     [
        //         'province_name'=>'Hậu Giang'
        //     ],
        //     [
        //         'province_name'=>'Hòa Bình'
        //     ],
        //     [
        //         'province_name'=>'Hưng Yên'
        //     ],
        //     [
        //         'province_name'=>'Khánh Hòa'
        //     ],
        //     [
        //         'province_name'=>'Kiên Giang'
        //     ],
        //     [
        //         'province_name'=>'Kon Tum'
        //     ],
        //     [
        //         'province_name'=>'Lai Châu'
        //     ],
        //     [
        //         'province_name'=>'Lâm Đồng'
        //     ],
        //     [
        //         'province_name'=>'Lạng Sơn'
        //     ],
        //     [
        //         'province_name'=>'Lào Cai'
        //     ],
        //     [
        //         'province_name'=>'Long An'
        //     ],
        //     [
        //         'province_name'=>'Nam Định'
        //     ],
        //     [
        //         'province_name'=>'Nghệ An'
        //     ],
        //     [
        //         'province_name'=>'Ninh Bình'
        //     ],
        //     [
        //         'province_name'=>'Ninh Thuận'
        //     ],
        //     [
        //         'province_name'=>'Phú Thọ'
        //     ],
        //     [
        //         'province_name'=>'Phú Yên'
        //     ],
        //     [
        //         'province_name'=>'Quảng Bình'
        //     ],
        //     [
        //         'province_name'=>'Quảng Nam'
        //     ],
        //     [
        //         'province_name'=>'Quảng Ngãi'
        //     ],
        //     [
        //         'province_name'=>'Quảng Ninh'
        //     ],
        //     [
        //         'province_name'=>'Quảng Trị'
        //     ],
        //     [
        //         'province_name'=>'Sóc Trăng'
        //     ],
        //     [
        //         'province_name'=>'Sơn La'
        //     ],
        //     [
        //         'province_name'=>'Tây Ninh'
        //     ],
        //     [
        //         'province_name'=>'Thái Bình'
        //     ],
        //     [
        //         'province_name'=>'Thái Nguyên'
        //     ],
        //     [
        //         'province_name'=>'Thanh Hóa'
        //     ],
        //     [
        //         'province_name'=>'Thừa Thiên Huế'
        //     ],
        //     [
        //         'province_name'=>'Tiền Giang'
        //     ],
        //     [
        //         'province_name'=>'TP Hồ Chí Minh'
        //     ],
        //     [
        //         'province_name'=>'Trà Vinh'
        //     ],
        //     [
        //         'province_name'=>'Tuyên Quang'
        //     ],
        //     [
        //         'province_name'=>'Vĩnh Long'
        //     ],
        //     [
        //         'province_name'=>'Vĩnh Phúc'
        //     ],
        //     [
        //         'province_name'=>'Yên Bái'
        //     ]

        // ];
        // DB::table('provinces')->insert($data_provinces);
        
      
        // $data_products_portfolio=[
        //     [
        //         'portfolio_name'=>'Dụng cụ bảo hộ'
        //     ],
        //     [
        //         'portfolio_name'=>'Đồ dùng cá nhân'
        //     ],
        //     [
        //         'portfolio_name'=>'Thiết bị hỗ trợ'
        //     ],
        //     [
        //         'portfolio_name'=>'Đồ Gia Dụng'
        //     ]

        // ];

        // DB::table('products_portfolio')->insert($data_products_portfolio);

    }
}
