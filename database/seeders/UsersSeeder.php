<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Zubayer Ahamed',
                'email' => 'cyclingbd007@gmail.com',
                'password' => Hash::make('12345678'), // Use a secure password in production
                'status' => 'ACTIVE',
                'register_type' => 'REGULAR',
                'is_system_admin' => true,
                'is_business_admin' => false,
                'is_driver' => false,
                'is_customer' => false,
            ],
            [
                'name' => 'Zubayer Ahamed',
                'email' => 'zubayerahamed.freelancer@gmail.com',
                'password' => Hash::make('12345678'),// Use a secure password in production
                'status' => 'ACTIVE',
                'register_type' => 'REGULAR',
                'is_system_admin' => false,
                'is_business_admin' => true,
                'is_driver' => false,
                'is_customer' => false,
            ],
        ]);
    }
}
