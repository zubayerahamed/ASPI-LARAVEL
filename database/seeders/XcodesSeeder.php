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


            // Product Type Data
            [
                'type' => 'Code Type',
                'xcode' => 'Product Type',
                'description' => '',
                'symbol' => '',
                'is_active' => true,
                'seqn' => 3,
                'business_id' => null,
            ],
            [
                'type' => 'Product Type',
                'xcode' => 'STANDARD',
                'description' => 'Stock Product (Physical Item)',
                'symbol' => '',
                'is_active' => true,
                'seqn' => 1,
                'business_id' => null,
            ],
            [
                'type' => 'Product Type',
                'xcode' => 'MANUFACTURED',
                'description' => 'Manufactured Product (BOM-Based)',
                'symbol' => '',
                'is_active' => true,
                'seqn' => 2,
                'business_id' => null,
            ],
            [
                'type' => 'Product Type',
                'xcode' => 'RAW_MATERIAL',
                'description' => 'Raw Material',
                'symbol' => '',
                'is_active' => true,
                'seqn' => 3,
                'business_id' => null,
            ],
            [
                'type' => 'Product Type',
                'xcode' => 'SERVICE',
                'description' => 'Service',
                'symbol' => '',
                'is_active' => true,
                'seqn' => 4,
                'business_id' => null,
            ],
            [
                'type' => 'Product Type',
                'xcode' => 'DIGITAL',
                'description' => 'Digital Product',
                'symbol' => '',
                'is_active' => true,
                'seqn' => 5,
                'business_id' => null,
            ],
            [
                'type' => 'Product Type',
                'xcode' => 'COMPOSITE',
                'description' => 'Composite/Bundle Product',
                'symbol' => '',
                'is_active' => true,
                'seqn' => 6,
                'business_id' => null,
            ],
            [
                'type' => 'Product Type',
                'xcode' => 'SUBSCRIPTION',
                'description' => 'Subscription/Recurring',
                'symbol' => '',
                'is_active' => true,
                'seqn' => 7,
                'business_id' => null,
            ],

            // Product Behaviour Data
            [
                'type' => 'Code Type',
                'xcode' => 'Product Behaviour',
                'description' => '',
                'symbol' => '',
                'is_active' => true,
                'seqn' => 4,
                'business_id' => null,
            ],
            [
                'type' => 'Product Behaviour',
                'xcode' => 'SIMPLE',
                'description' => 'Simple Product',
                'symbol' => '',
                'is_active' => true,
                'seqn' => 1,
                'business_id' => null,
            ],
            [
                'type' => 'Product Behaviour',
                'xcode' => 'VARIABLE',
                'description' => 'Variable Product',
                'symbol' => '',
                'is_active' => true,
                'seqn' => 2,
                'business_id' => null,
            ],
            [
                'type' => 'Product Behaviour',
                'xcode' => 'EXTERNAL',
                'description' => 'External/Affiliate Product',
                'symbol' => '',
                'is_active' => true,
                'seqn' => 3,
                'business_id' => null,
            ],
            [
                'type' => 'Product Behaviour',
                'xcode' => 'GROUPED',
                'description' => 'Grouped Product',
                'symbol' => '',
                'is_active' => true,
                'seqn' => 4,
                'business_id' => null,
            ],
            [
                'type' => 'Product Behaviour',
                'xcode' => 'BUNDLE_PARENT',
                'description' => 'Bundle Parent Product',
                'symbol' => '',
                'is_active' => true,
                'seqn' => 5,
                'business_id' => null,
            ],
            [
                'type' => 'Product Behaviour',
                'xcode' => 'BUNDLE_ITEM',
                'description' => 'Bundle Item Product',
                'symbol' => '',
                'is_active' => true,
                'seqn' => 6,
                'business_id' => null,
            ],
            [
                'type' => 'Product Behaviour',
                'xcode' => 'ADDON_PARENT',
                'description' => 'Addon Parent Product',
                'symbol' => '',
                'is_active' => true,
                'seqn' => 7,
                'business_id' => null,
            ],
            [
                'type' => 'Product Behaviour',
                'xcode' => 'ADDON_ITEM',
                'description' => 'Addon Item Product',
                'symbol' => '',
                'is_active' => true,
                'seqn' => 7,
                'business_id' => null,
            ],
            [
                'type' => 'Product Behaviour',
                'xcode' => 'SET_MENU',
                'description' => 'Set Menu Product',
                'symbol' => '',
                'is_active' => true,
                'seqn' => 7,
                'business_id' => null,
            ],
            [
                'type' => 'Product Behaviour',
                'xcode' => 'CONFIGURABLE',
                'description' => 'Configurable Product',
                'symbol' => '',
                'is_active' => true,
                'seqn' => 8,
                'business_id' => null,
            ],
            [
                'type' => 'Product Behaviour',
                'xcode' => 'SUBSCRIPTION_RULES',
                'description' => 'Subscription Rules Product',
                'symbol' => '',
                'is_active' => true,
                'seqn' => 9,
                'business_id' => null,
            ],
            
            
            



        ]);
    }
}
