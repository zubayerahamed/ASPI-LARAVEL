<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $adminId = DB::table('menus')->insertGetId([
            'xmenu' => 'M100',
            'title' => 'Business Administration',
            'icon' => 'ph ph-align-left',
            'seqn' => 1,
            'parent_menu_id' => null,
            'business_id' => null
        ]);

        $accountingId = DB::table('menus')->insertGetId([
            'xmenu' => 'M200',
            'title' => 'Accounting',
            'icon' => 'ph ph-align-left',
            'seqn' => 2,
            'parent_menu_id' => null,
            'business_id' => null
        ]);

        $procurementId = DB::table('menus')->insertGetId([
            'xmenu' => 'M300',
            'title' => 'Procurement',
            'icon' => 'ph ph-align-left',
            'seqn' => 3,
            'parent_menu_id' => null,
            'business_id' => null
        ]);

        $salesId = DB::table('menus')->insertGetId([
            'xmenu' => 'M400',
            'title' => 'Sales',
            'icon' => 'ph ph-align-left',
            'seqn' => 4,
            'parent_menu_id' => null,
            'business_id' => null
        ]);

        $inventoryId = DB::table('menus')->insertGetId([
            'xmenu' => 'M500',
            'title' => 'Inventory',
            'icon' => 'ph ph-align-left',
            'seqn' => 5,
            'parent_menu_id' => null,
            'business_id' => null
        ]);



        DB::table('menus')->insert([
            // ======= Administration =======
            [
                'xmenu' => 'M101',
                'title' => 'Administration',
                'icon' => 'ph ph-align-left',
                'seqn' => 1,
                'parent_menu_id' => $adminId,
                'business_id' => null
            ],
            [
                'xmenu' => 'M102',
                'title' => 'Master Data',
                'icon' => 'ph ph-align-left',
                'seqn' => 2,
                'parent_menu_id' => $adminId,
                'business_id' => null
            ],
            [
                'xmenu' => 'M103',
                'title' => 'Administration Report',
                'icon' => 'ph ph-align-left',
                'seqn' => 2,
                'parent_menu_id' => $adminId,
                'business_id' => null
            ],


            // ======== Accounting ===========
            [
                'xmenu' => 'M201',
                'title' => 'General Accounting',
                'icon' => 'ph ph-align-left',
                'seqn' => 1,
                'parent_menu_id' => $accountingId,
                'business_id' => null
            ],
            [
                'xmenu' => 'M202',
                'title' => 'GL Interface',
                'icon' => 'ph ph-align-left',
                'seqn' => 2,
                'parent_menu_id' => $accountingId,
                'business_id' => null
            ],
            [
                'xmenu' => 'M203',
                'title' => 'Accounting Report',
                'icon' => 'ph ph-align-left',
                'seqn' => 2,
                'parent_menu_id' => $accountingId,
                'business_id' => null
            ],




            // ======== Procurement ===========
            [
                'xmenu' => 'M301',
                'title' => 'Purchase & Procurement',
                'icon' => 'ph ph-align-left',
                'seqn' => 1,
                'parent_menu_id' => $procurementId,
                'business_id' => null
            ],
            [
                'xmenu' => 'M302',
                'title' => 'Procurement Report',
                'icon' => 'ph ph-align-left',
                'seqn' => 2,
                'parent_menu_id' => $procurementId,
                'business_id' => null
            ],

            // ======== Sales ===========
            [
                'xmenu' => 'M401',
                'title' => 'Sales & Invoices',
                'icon' => 'ph ph-align-left',
                'seqn' => 1,
                'parent_menu_id' => $salesId,
                'business_id' => null
            ],
            [
                'xmenu' => 'M402',
                'title' => 'Sales Report',
                'icon' => 'ph ph-align-left',
                'seqn' => 2,
                'parent_menu_id' => $salesId,
                'business_id' => null
            ],


            // ======== Inventory ===========
            [
                'xmenu' => 'M501',
                'title' => 'Inventory Management',
                'icon' => 'ph ph-align-left',
                'seqn' => 1,
                'parent_menu_id' => $inventoryId,
                'business_id' => null
            ],
            [
                'xmenu' => 'M502',
                'title' => 'Inventory Report',
                'icon' => 'ph ph-align-left',
                'seqn' => 2,
                'parent_menu_id' => $inventoryId,
                'business_id' => null
            ],

        ]);
    }
}
