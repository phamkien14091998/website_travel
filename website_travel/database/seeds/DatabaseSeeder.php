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
                'password' => '12345',
                'full_name' => 'Phạm Duy KienAdmin',
                'avatar' => 'kienadmin.PNG',
                'date_of_birth' => '1998-09-14',
                'gender' => '1',
                'hometown' => 'Ninh Bình',
                'hobbies' => 'Đá bóng với đá cầu nhảy dây bắn bi trốn tìm',
                'role' => '1',
            ],
            [
                'user_name' => 'Vu Admin',
                'email' => 'vuadmin@gmail.com',
                'password' => '12345',
                'full_name' => 'Phan Cong Nhat VuAdmin',
                'avatar' => 'vuadmin.PNG',
                'date_of_birth' => '1998-07-20',
                'gender' => '1',
                'hometown' => 'Huế',
                'hobbies' => 'Tenis cầu lông',
                'role' => '1',
            ],
            
        ];
        DB::table('users')->insert($data);

    }
}
