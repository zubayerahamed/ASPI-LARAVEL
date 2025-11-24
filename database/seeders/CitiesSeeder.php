<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // CITY LIST GROUPED BY COUNTRY > STATE CODE
        $data = [

            // ---------------------------------
            // Bangladesh (BD)
            // ---------------------------------
            'BD' => [
                'DH' => ['Dhaka', 'Gazipur', 'Narayanganj'],
                'CT' => ['Chattogram', 'Cox\'s Bazar', 'Feni'],
                'KH' => ['Khulna', 'Jessore', 'Satkhira'],
            ],

            // ---------------------------------
            // India (IN)
            // ---------------------------------
            'IN' => [
                'MH' => ['Mumbai', 'Pune', 'Nagpur'],
                'WB' => ['Kolkata', 'Siliguri', 'Howrah'],
                'DL' => ['New Delhi', 'Dwarka', 'Karol Bagh'],
            ],

            // ---------------------------------
            // United States (US)
            // ---------------------------------
            'US' => [
                'CA' => ['Los Angeles', 'San Diego', 'San Francisco'],
                'TX' => ['Houston', 'Dallas', 'Austin'],
                'NY' => ['New York City', 'Buffalo', 'Rochester'],
            ],

        ];


        foreach ($data as $countryIso2 => $states) {

            // Resolve country ID
            $countryId = DB::table('countries')->where('iso2', $countryIso2)->value('id');
            if (!$countryId) {
                echo "Country not found: $countryIso2 — skipping...\n";
                continue;
            }

            foreach ($states as $stateCode => $cities) {

                // Resolve state ID by state code + country
                $stateId = DB::table('states')
                    ->where('state_code', $stateCode)
                    ->where('country_id', $countryId)
                    ->value('id');

                if (!$stateId) {
                    echo "State not found: $stateCode ($countryIso2) — skipping...\n";
                    continue;
                }

                // Insert each city
                foreach ($cities as $cityName) {
                    DB::table('cities')->insert([
                        'state_id'  => $stateId,
                        'name'      => $cityName,
                        'is_active' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
