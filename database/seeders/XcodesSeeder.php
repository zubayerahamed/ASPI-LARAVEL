<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class XcodesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('xcodes')->insert([
            // Country Data
            [
                'type' => 'Code Type',
                'xcode' => 'Country',
                'description' => '',
                'symbol' => '',
                'is_active' => true,
                'seqn' => 1,
                'business_id' => null,
            ],
            [
                'type' => 'Country',
                'xcode' => 'BD',
                'description' => 'Bangladesh',
                'symbol' => '',
                'is_active' => true,
                'seqn' => 1,
                'business_id' => null,
            ],
            [
                'type' => 'Country',
                'xcode' => 'IN',
                'description' => 'India',
                'symbol' => '',
                'is_active' => true,
                'seqn' => 2,
                'business_id' => null,
            ],
            [
                'type' => 'Country',
                'xcode' => 'PK',
                'description' => 'Pakistan',
                'symbol' => '',
                'is_active' => true,
                'seqn' => 3,
                'business_id' => null,
            ],
            [
                'type' => 'Country',
                'xcode' => 'US',
                'description' => 'United States of America',
                'symbol' => '',
                'is_active' => true,
                'seqn' => 4,
                'business_id' => null,
            ],
            [
                'type' => 'Country',
                'xcode' => 'UK',
                'description' => 'United Kingdom',
                'symbol' => '',
                'is_active' => true,
                'seqn' => 5,
                'business_id' => null,
            ],


            // Currency Data
            [
                'type' => 'Code Type',
                'xcode' => 'Currency',
                'description' => '',
                'symbol' => '',
                'is_active' => true,
                'seqn' => 2,
                'business_id' => null,
            ],
            [
                'type' => 'Currency',
                'xcode' => 'BDT',
                'description' => 'Bangladeshi Taka',
                'symbol' => '৳',
                'is_active' => true,
                'seqn' => 1,
                'business_id' => null,
            ],
            [
                'type' => 'Currency',
                'xcode' => 'INR',
                'description' => 'Indian Rupee',
                'symbol' => '₹',
                'is_active' => true,
                'seqn' => 2,
                'business_id' => null,
            ],
            [
                'type' => 'Currency',
                'xcode' => 'PKR',
                'description' => 'Pakistani Rupee',
                'symbol' => '₨',
                'is_active' => true,
                'seqn' => 3,
                'business_id' => null,
            ],
            [
                'type' => 'Currency',
                'xcode' => 'USD',
                'description' => 'United States Dollar',
                'symbol' => '$',
                'is_active' => true,
                'seqn' => 4,
                'business_id' => null,
            ],
            [
                'type' => 'Currency',
                'xcode' => 'GBP',
                'description' => 'British Pound Sterling',
                'symbol' => '£',
                'is_active' => true,
                'seqn' => 5,
                'business_id' => null,
            ],


            // Customer Group Data
            [
                'type' => 'Code Type',
                'xcode' => 'Customer Group',
                'description' => '',
                'symbol' => '',
                'is_active' => true,
                'seqn' => 3,
                'business_id' => null,
            ],
            [
                'type' => 'Customer Group',
                'xcode' => 'Corporate',
                'description' => 'Corporate Customers',
                'symbol' => '',
                'is_active' => true,
                'seqn' => 1,
                'business_id' => null,
            ],
            [
                'type' => 'Customer Group',
                'xcode' => 'General',
                'description' => 'General Customers',
                'symbol' => '',
                'is_active' => true,
                'seqn' => 2,
                'business_id' => null,
            ],

            // Supplier Group Data
            [
                'type' => 'Code Type',
                'xcode' => 'Supplier Group',
                'description' => '',
                'symbol' => '',
                'is_active' => true,
                'seqn' => 3,
                'business_id' => null,
            ],
            [
                'type' => 'Supplier Group',
                'xcode' => 'Foreign',
                'description' => 'Foreign Suppliers',
                'symbol' => '',
                'is_active' => true,
                'seqn' => 1,
                'business_id' => null,
            ],
            [
                'type' => 'Supplier Group',
                'xcode' => 'Local',
                'description' => 'Local Suppliers',
                'symbol' => '',
                'is_active' => true,
                'seqn' => 2,
                'business_id' => null,
            ],


            // Unit of Measurement Data
            [
                'type' => 'Code Type',
                'xcode' => 'Unit of Measurement',
                'description' => '',
                'symbol' => '',
                'is_active' => true,
                'seqn' => 3,
                'business_id' => null,
            ],
            [
                'type' => 'Unit of Measurement',
                'xcode' => 'kg',
                'description' => 'Kilogram',
                'symbol' => '',
                'is_active' => true,
                'seqn' => 1,
                'business_id' => null,
            ],
            [
                'type' => 'Unit of Measurement',
                'xcode' => 'pcs',
                'description' => 'Pieces',
                'symbol' => '',
                'is_active' => true,
                'seqn' => 2,
                'business_id' => null,
            ],


            // Item Group Data
            [
                'type' => 'Code Type',
                'xcode' => 'Item Group',
                'description' => '',
                'symbol' => '',
                'is_active' => true,
                'seqn' => 3,
                'business_id' => null,
            ],
            [
                'type' => 'Item Group',
                'xcode' => 'Accessories',
                'description' => 'Accessories',
                'symbol' => '',
                'is_active' => true,
                'seqn' => 1,
                'business_id' => null,
            ],
            [
                'type' => 'Item Group',
                'xcode' => 'Finished Goods',
                'description' => 'Finished Goods',
                'symbol' => '',
                'is_active' => true,
                'seqn' => 2,
                'business_id' => null,
            ],
            [
                'type' => 'Item Group',
                'xcode' => 'Raw Materials',
                'description' => 'Raw Materials',
                'symbol' => '',
                'is_active' => true,
                'seqn' => 3,
                'business_id' => null,
            ],
            [
                'type' => 'Item Group',
                'xcode' => 'Services',
                'description' => 'Services',
                'symbol' => '',
                'is_active' => true,
                'seqn' => 4,
                'business_id' => null,
            ],
            [
                'type' => 'Item Group',
                'xcode' => 'Digital Goods',
                'description' => 'Digital Goods',
                'symbol' => '',
                'is_active' => true,
                'seqn' => 5,
                'business_id' => null,
            ],



        ]);
    }
}
