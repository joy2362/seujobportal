<?php

use Illuminate\Database\Seeder;
use App\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'name' => 'Abdullah Zahid',
            'user_type' => '1',
            'pro_pic' => 'asset/img/admin/joy2362.jpg',
            'email' => 'abdullahzahidjoy@gmail.com',
            'email_verified_at'=>'2020-02-27 13:46:39',
            'password' => Hash::make('1234'),
            'verify' => Hash::make('2362'),
        ]);
    }
}
