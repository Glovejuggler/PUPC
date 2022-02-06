<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'middle_name' => '',
            'email' => 'admin@admin.com',
            'address' => 'Calauan, Laguna',
            'password' => Hash::make('admin123'),
            'role' => 'Admin',
        ]);
    }
}
