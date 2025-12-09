<?php

namespace Database\Seeders;

use App\Models\Business;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $business = Business::where('name', 'Bithis Kitchen')->where('is_active', true)->firstOrFail();

        // Tax Components
        DB::table('tax_components')->insert([
            [
                'code' => 'VAT',
                'name' => 'Value Added Tax',
                'description' => 'A tax on the value added to goods and services.',
                'is_recoverable' => true,
                'business_id' => $business->id,
            ],
            [
                'code' => 'SD',
                'name' => 'Sales Duty',
                'description' => 'A tax imposed on certain goods and services at the point of sale.',
                'is_recoverable' => false,
                'business_id' => $business->id,
            ],
            [
                'code' => 'AIT',
                'name' => 'Advance Income Tax',
                'description' => 'A tax collected in advance on certain transactions.',
                'is_recoverable' => false,
                'business_id' => $business->id,
            ],
        ]);


        // Tax Categories
        DB::table('tax_categories')->insert([
            [
                'name' => 'Standard VAT',
                'description' => 'Standard VAT rate applicable to most goods and services.',
                'business_id' => $business->id,
            ],
            [
                'name' => 'VAT Exempt',
                'description' => 'VAT exempt rate applicable to certain goods and services.',
                'business_id' => $business->id,
            ],
            [
                'name' => 'VAT Inclusive',
                'description' => 'VAT inclusive rate applicable to certain goods and services.',
                'business_id' => $business->id,
            ],
            [
                'name' => 'VAT SD Compound',
                'description' => 'VAT and Sales Duty compound rate applicable to certain goods and services.',
                'business_id' => $business->id,
            ],
        ]);


        // Tax Rules
        $standardVatCategory = DB::table('tax_categories')
            ->where('name', 'Standard VAT')
            ->where('business_id', $business->id)
            ->first();

        DB::table('tax_rules')->insert([
            [
                'notes' => 'Standard VAT rule for sales transactions.',
                'transaction_type' => 'SALES',
                'effective_from' => '2025-01-01',
                'effective_to' => null,
                'tax_category_id' => $standardVatCategory->id,
                'business_id' => $business->id,
            ],
            [
                'notes' => 'Standard VAT rule for purchase transactions.',
                'transaction_type' => 'PURCHASE',
                'effective_from' => '2025-01-01',
                'effective_to' => null,
                'tax_category_id' => $standardVatCategory->id,
                'business_id' => $business->id,
            ],
        ]);


        // Tax Rule Components
        $standardVatRuleSales = DB::table('tax_rules')
            ->where('notes', 'Standard VAT rule for sales transactions.')
            ->where('transaction_type', 'SALES')
            ->where('business_id', $business->id)
            ->first();

        $vatComponent = DB::table('tax_components')
            ->where('code', 'VAT')
            ->where('business_id', $business->id)
            ->first();

        DB::table('tax_rule_components')->insert([
            [
                'tax_rule_id' => $standardVatRuleSales->id,
                'tax_component_id' => $vatComponent->id,
                'rate' => 15.00, // 15% VAT
                'calc_type' => 'EXCLUSIVE',
                'seqn' => 1,
                'is_recoverable' => true,
            ],
        ]);
    }
}
