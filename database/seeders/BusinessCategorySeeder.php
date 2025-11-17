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
                'name' => 'Restaurants / Cloud Kitchens',
                'seqn' => 1,
                'is_active' => true,
            ],
            [
                'xcode' => '1001',
                'name' => 'Bakeries / Pastry & Sweets',
                'seqn' => 2,
                'is_active' => true,
            ],
            [
                'xcode' => '1002',
                'name' => 'Groceries / Convenience Stores',
                'seqn' => 3,
                'is_active' => true,
            ],
            [
                'xcode' => '1100',
                'name' => 'Home / Furniture',
                'seqn' => 4,
                'is_active' => true,
            ],
            [
                'xcode' => '1101',
                'name' => 'Garden / Nursery / Home Improvement',
                'seqn' => 5,
                'is_active' => true,
            ],
            [
                'xcode' => '1200',
                'name' => 'Pet Care',
                'seqn' => 6,
                'is_active' => true,
            ],
            [
                'xcode' => '1300',
                'name' => 'Toys / Crafts / Hobbies',
                'seqn' => 7,
                'is_active' => true,
            ],
            [
                'xcode' => '1400',
                'name' => 'Books / Arts / Music',
                'seqn' => 8,
                'is_active' => true,
            ],
            [
                'xcode' => '1500',
                'name' => 'Jewellery / Accessories / Lifestyle',
                'seqn' => 9,
                'is_active' => true,
            ],
            [
                'xcode' => '1501',
                'name' => 'Clothing / Shoes / Accessories',
                'seqn' => 10,
                'is_active' => true,
            ],
            [
                'xcode' => '1600',
                'name' => 'Health / Beauty',
                'seqn' => 11,
                'is_active' => true,
            ],
            [
                'xcode' => '1700',
                'name' => 'Gifts / Flowers / Collectibles',
                'seqn' => 12,
                'is_active' => true,
            ],
            [
                'xcode' => '1800',
                'name' => 'Electronics / Gadgets',
                'seqn' => 13,
                'is_active' => true,
            ],
            [
                'xcode' => '1900',
                'name' => 'Sports / Fitness / Outdoors',
                'seqn' => 14,
                'is_active' => true,
            ],
            [
                'xcode' => '2000',
                'name' => 'Automobile / Parts / Hardware',
                'seqn' => 15,
                'is_active' => true,
            ],
            [
                'xcode' => '2100',
                'name' => 'Software Products',
                'seqn' => 16,
                'is_active' => true,
            ],
            [
                'xcode' => '2200',
                'name' => 'Services',
                'seqn' => 17,
                'is_active' => true,
            ],
            [
                'xcode' => '2300',
                'name' => 'Others',
                'seqn' => 18,
                'is_active' => true,
            ],

        ]);
    }
}
