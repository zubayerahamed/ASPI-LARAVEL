<?php

namespace Database\Seeders;

use App\Models\BusinessCategory;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $businessCategory = BusinessCategory::where('xcode', '1000')->firstOrFail();

        DB::table('businesses')->insert([
            [
                'name' => 'Bithis Kitchen',
                'logo' => null,
                'country' => 'BD',
                'currency' => 'BDT',
                'email' => 'zubayerahamed1990@gmail.com',
                'mobile' => '01515634889',
                'is_inhouse' => true,
                'is_pickup' => true,
                'is_delivery' => true,
                'is_active' => true,

                'is_allow_custom_menu' => false,
                'is_allow_custom_xcodes' => false,
                'is_allow_custom_category' => true,
                'is_allow_custom_attribute' => true,
                'is_allow_custom_tags' => true,
                'is_allow_custom_product_labels' => true,
                'is_allow_custom_product_options' => true,
                'is_allow_custom_product_specifications' => true,

                'business_category_id' => $businessCategory->id,
            ]
        ]);

        // Assign business to system admin and business admin users
        $business = DB::table('businesses')->where('name', 'Bithis Kitchen')->first();  

        $systemAdmin = User::where('email', 'cyclingbd007@gmail.com')->first();
        $businessAdmin = User::where('email', 'zubayerahamed.freelancer@gmail.com')->first();

        $systemAdmin->businesses()->attach($business->id);
        $businessAdmin->businesses()->attach($business->id);
    }
}
