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

        $data=[
            [
                'user_name' => 'Kien Admin',
                'email' => 'kienadmin@gmail.com',
                'password' => '$2y$10$uFH/4L7itJlD3cKJKgQRKeafDRptTfGOrgmdiLu.4baLoO8/ojJJe',
                'full_name' => 'Phạm Duy KienAdmin',
                'avatar' => 'upload-avatar/img_kienAdmin.PNG',
                'date_of_birth' => '1998-09-14',
                'gender' => '1',
                'hometown' => 'Ninh Bình',
                'hobbies' => 'Đá bóng với đá cầu nhảy dây bắn bi trốn tìm',
                'role' => '1',
            ],
            [
                'user_name' => 'Vu Admin',
                'email' => 'vuadmin@gmail.com',
                'password' => '$2y$10$uFH/4L7itJlD3cKJKgQRKeafDRptTfGOrgmdiLu.4baLoO8/ojJJe',
                'full_name' => 'Phan Cong Nhat VuAdmin',
                'avatar' => 'upload-avatar/img_vuAdmin.PNG',
                'date_of_birth' => '1996-07-20',
                'gender' => '1',
                'hometown' => 'Huế',
                'hobbies' => 'Tenis cầu lông',
                'role' => '1',
            ],
            
        ];
        DB::table('users')->insert($data);

        $data_provinces = [
            [
                'province_name'=>'An Giang',
                'image'=>'image_province/an_giang.jpg'
            ],
            [
                'province_name'=>'Bà Rịa – Vũng Tàu',
                'image'=>'image_province/vung_tau.jpg'
            ],
            [
                'province_name'=>'Bắc Giang',
                'image'=>'image_province/bac_giang.jpg'
            ],
            [
                'province_name'=>'Bắc Kạn',
                'image'=>'image_province/bac_kan.jpg'
            ],
            [
                'province_name'=>'Bạc Liêu',
                'image'=>'image_province/bac_lieu.jpg'
            ],
            [
                'province_name'=>'Bắc Ninh',
                'image'=>'image_province/bac_ninh.jpg'
            ],
            [
                'province_name'=>'Bến Tre',
                'image'=>'image_province/ben_tre.jpg'
            ],
            [
                'province_name'=>'Bình Định',
                'image'=>'image_province/binh_dinh.jpg'
            ],
            [
                'province_name'=>'Bình Dương',
                'image'=>'image_province/binh_duong.jpg'
            ],
            [
                'province_name'=>'Bình Phước',
                'image'=>'image_province/binh_phuoc.jpg'
            ],
            [
                'province_name'=>'Bình Thuận',
                'image'=>'image_province/binh_thuan.jpg'
            ],
            [
                'province_name'=>'Cà Mau',
                'image'=>'image_province/ca_mau.jpg'
            ],
            [
                'province_name'=>'Cần Thơ',
                'image'=>'image_province/can_tho.jpg'
            ],
            [
                'province_name'=>'Cao Bằng',
                'image'=>'image_province/cao_bang.jpg'
            ],
            [
                'province_name'=>'Đà Nẵng',
                'image'=>'image_province/da_nang.jpg'
            ],
            [
                'province_name'=>'Đắk Lắk',
                'image'=>'image_province/dak_lak.jpg'
            ],
            [
                'province_name'=>'Đắk Nông',
                'image'=>'image_province/dak_nong.jpg'
            ],
            [
                'province_name'=>'Điện Biên',
                'image'=>'image_province/dien_bien.jpg'
            ],
            [
                'province_name'=>'Đồng Nai',
                'image'=>'image_province/dong_nai.jpg'
            ],
            [
                'province_name'=>'Đồng Tháp',
                'image'=>'image_province/dong_thap.jpg'
            ],
            [
                'province_name'=>'Gia Lai',
                'image'=>'image_province/gia_lai.jpg'
            ],
            [
                'province_name'=>'Hà Giang',
                'image'=>'image_province/ha_giang.jpg'
            ],
            [
                'province_name'=>'Hà Nam',
                'image'=>'image_province/ha_nam.jpg'
            ],
            [
                'province_name'=>'Hà Nội',
                'image'=>'image_province/ha_noi.jpg'
            ],
            [
                'province_name'=>'Hà Tĩnh',
                'image'=>'image_province/ha_tinh.jpg'
            ],
            [
                'province_name'=>'Hải Dương',
                'image'=>'image_province/hai_duong.jpg'
            ],
            [
                'province_name'=>'Hải Phòng',
                'image'=>'image_province/hai_phong.jpg'
            ],
            [
                'province_name'=>'Hậu Giang',
                'image'=>'image_province/hau_giang.jpg'
            ],
            [
                'province_name'=>'Hòa Bình',
                'image'=>'image_province/hoa_binh.jpg'
            ],
            [
                'province_name'=>'Hưng Yên',
                'image'=>'image_province/hung_yen.jpg'
            ],
            [
                'province_name'=>'Khánh Hòa',
                'image'=>'image_province/khanh_hoa.jpg'
            ],
            [
                'province_name'=>'Kiên Giang',
                'image'=>'image_province/kien_giang.jpg'
            ],
            [
                'province_name'=>'Kon Tum',
                'image'=>'image_province/kon_tum.jpg'
            ],
            [
                'province_name'=>'Lai Châu',
                'image'=>'image_province/lai_chau.jpg'
            ],
            [
                'province_name'=>'Lâm Đồng',
                'image'=>'image_province/lam_dong.jpg'
            ],
            [
                'province_name'=>'Lạng Sơn',
                'image'=>'image_province/lang_son.jpg'
            ],
            [
                'province_name'=>'Lào Cai',
                'image'=>'image_province/lao_cai.jpg'
            ],
            [
                'province_name'=>'Long An',
                'image'=>'image_province/long_an.jpg'
            ],
            [
                'province_name'=>'Nam Định',
                'image'=>'image_province/nam_dinh.jpg'
            ],
            [
                'province_name'=>'Nghệ An',
                'image'=>'image_province/nghe_an.jpg'
            ],
            [
                'province_name'=>'Ninh Bình',
                'image'=>'image_province/ninh_binh.jpg'
            ],
            [
                'province_name'=>'Ninh Thuận',
                'image'=>'image_province/ninh_thuan.jpg'
            ],
            [
                'province_name'=>'Phú Thọ',
                'image'=>'image_province/phu_tho.jpg'
            ],
            [
                'province_name'=>'Phú Yên',
                'image'=>'image_province/phu_yen.jpg'
            ],
            [
                'province_name'=>'Quảng Bình',
                'image'=>'image_province/quang_binh.jpg'
            ],
            [
                'province_name'=>'Quảng Nam',
                'image'=>'image_province/quang_nam.jpg'
            ],
            [
                'province_name'=>'Quảng Ngãi',
                'image'=>'image_province/quang_ngai.jpg'
            ],
            [
                'province_name'=>'Quảng Ninh',
                'image'=>'image_province/quang_ninh.jpg'
            ],
            [
                'province_name'=>'Quảng Trị',
                'image'=>'image_province/quang_tri.jpg'
            ],
            [
                'province_name'=>'Sóc Trăng',
                'image'=>'image_province/soc_trang.jpg'
            ],
            [
                'province_name'=>'Sơn La',
                'image'=>'image_province/son_la.jpg'
            ],
            [
                'province_name'=>'Tây Ninh',
                'image'=>'image_province/tay_ninh.jpg'
            ],
            [
                'province_name'=>'Thái Bình',
                'image'=>'image_province/thai_binh.jpg'
            ],
            [
                'province_name'=>'Thái Nguyên',
                'image'=>'image_province/thai_nguyen.jpg'
            ],
            [
                'province_name'=>'Thanh Hóa',
                'image'=>'image_province/thanh_hoa.jpg'
            ],
            [
                'province_name'=>'Thừa Thiên Huế',
                'image'=>'image_province/thua_thien_hue.jpg'
            ],
            [
                'province_name'=>'Tiền Giang',
                'image'=>'image_province/tien_giang.jpg'
            ],
            [
                'province_name'=>'TP Hồ Chí Minh',
                'image'=>'image_province/ho_chi_minh.jpg'
            ],
            [
                'province_name'=>'Trà Vinh',
                'image'=>'image_province/tra_vinh.jpg'
            ],
            [
                'province_name'=>'Tuyên Quang',
                'image'=>'image_province/tuyen_quang.jpg'
            ],
            [
                'province_name'=>'Vĩnh Long',
                'image'=>'image_province/vinh_long.jpg'
            ],
            [
                'province_name'=>'Vĩnh Phúc',
                'image'=>'image_province/vinh_phuc.jpg'
            ],
            [
                'province_name'=>'Yên Bái',
                'image'=>'image_province/yen_bai.jpg'
            ]

        ];
        DB::table('provinces')->insert($data_provinces);
        
      
        $data_products_portfolio=[
            [
                'portfolio_name'=>'Dụng cụ bảo hộ'
            ],
            [
                'portfolio_name'=>'Đồ dùng cá nhân'
            ],
            [
                'portfolio_name'=>'Thiết bị hỗ trợ'
            ],
            [
                'portfolio_name'=>'Đồ Gia Dụng'
            ]

        ];

        DB::table('products_portfolio')->insert($data_products_portfolio);

        $data_vehicle=[
                [
                    'title' => 'Tàu hỏa',
                    'description' => 'fa fa-subway'
                ],
                [
                    'title' => 'Bus',
                    'description' => 'fa fa-bus'
                ],
                [
                    'title' => 'Taxi/Car',
                    'description' => 'fa fa-taxi'
                ],
                [
                    'title' => 'Xe đạp',
                    'description' => 'fa fa-bicycle'
                ],
                [
                    'title' => 'Tàu thủy',
                    'description' => 'fa fa-ship'
                ],
                [
                    'title' => 'Máy bay',
                    'description' => 'fa fa-plane'
                ],
                [
                    'title' => 'Xe máy',
                    'description' => 'fa fa-motorcycle'
                ],
                [
                    'title' => 'Đi bộ',
                    'description' => 'fa fa-paw'
                ],
                
            ];
            DB::table('vehicles')->insert($data_vehicle);

    }
}
