<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BusinessCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('business_categories')->insert([
            [
                'xcode' => '1000',
                'name' => 'GENERAL',
                'seqn' => 1,
                'is_active' => true,
            ],
            [
                'xcode' => '2000',
                'name' => 'FOOD',
                'seqn' => 2,
                'is_active' => true,
            ],
            [
                'xcode' => '3000',
                'name' => 'FASHION',
                'seqn' => 3,
                'is_active' => true,
            ],
            [
                'xcode' => '4000',
                'name' => 'ELECTRONICS',
                'seqn' => 4,
                'is_active' => true,
            ],
        ]);
    }
}
