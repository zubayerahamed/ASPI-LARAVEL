<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // List of states grouped by country ISO2
        $data = [

            // ------------------------------
            // Bangladesh
            // ------------------------------
            'BD' => [
                ['name' => 'Dhaka',        'state_code' => 'DH'],
                ['name' => 'Chattogram',   'state_code' => 'CT'],
                ['name' => 'Khulna',       'state_code' => 'KH'],
                ['name' => 'Rajshahi',     'state_code' => 'RJ'],
                ['name' => 'Sylhet',       'state_code' => 'SY'],
                ['name' => 'Barishal',     'state_code' => 'BR'],
                ['name' => 'Rangpur',      'state_code' => 'RP'],
                ['name' => 'Mymensingh',   'state_code' => 'MY'],
            ],

            // ------------------------------
            // India
            // ------------------------------
            'IN' => [
                ['name' => 'Maharashtra',  'state_code' => 'MH'],
                ['name' => 'West Bengal',  'state_code' => 'WB'],
                ['name' => 'Uttar Pradesh','state_code' => 'UP'],
                ['name' => 'Gujarat',      'state_code' => 'GJ'],
                ['name' => 'Tamil Nadu',   'state_code' => 'TN'],
                ['name' => 'Karnataka',    'state_code' => 'KA'],
                ['name' => 'Punjab',       'state_code' => 'PB'],
                ['name' => 'Delhi',        'state_code' => 'DL'],
            ],

            // ------------------------------
            // United States
            // ------------------------------
            'US' => [
                ['name' => 'California',   'state_code' => 'CA'],
                ['name' => 'Texas',        'state_code' => 'TX'],
                ['name' => 'Florida',      'state_code' => 'FL'],
                ['name' => 'New York',     'state_code' => 'NY'],
                ['name' => 'Illinois',     'state_code' => 'IL'],
                ['name' => 'Ohio',         'state_code' => 'OH'],
                ['name' => 'Georgia',      'state_code' => 'GA'],
                ['name' => 'North Carolina','state_code' => 'NC'],
            ],
        ];

        foreach ($data as $iso2 => $states) {

            // Resolve country ID dynamically
            $countryId = DB::table('countries')->where('iso2', $iso2)->value('id');

            if (!$countryId) {
                echo "Country not found: $iso2 — skipping...\n";
                continue;
            }

            // Insert states with correct country_id
            foreach ($states as $state) {
                DB::table('states')->insert([
                    'country_id' => $countryId,
                    'name'       => $state['name'],
                    'state_code' => $state['state_code'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }


    }
}
