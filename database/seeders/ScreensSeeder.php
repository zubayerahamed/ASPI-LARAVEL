<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScreensSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('screens')->insert([
            // ======= Administration =======
            ['xscreen' => 'DASH', 'title' => 'Dashboard', 'icon' => 'ph ph-speedometer', 'keywords' => 'dashboard,home,main', 'type' => 'SCREEN', 'xnum' => 0, 'seqn' => 1,],
            ['xscreen' => 'AD01', 'title' => 'Business Settings/Profile', 'icon' => 'ph ph-buildings', 'keywords' => 'business,settings,profile', 'type' => 'SCREEN', 'xnum' => 0, 'seqn' => 2],
            ['xscreen' => 'AD02', 'title' => 'Menu', 'icon' => 'ph ph-align-left', 'keywords' => 'menu', 'type' => 'SCREEN', 'xnum' => 0, 'seqn' => 3],
            ['xscreen' => 'AD03', 'title' => 'Navigation management', 'icon' => 'ph ph-anchor-simple', 'keywords' => 'navigation', 'type' => 'SCREEN', 'xnum' => 0, 'seqn' => 4],
            ['xscreen' => 'AD04', 'title' => 'Codes & Parameters', 'icon' => 'ph ph-tree-structure', 'keywords' => 'business,settings,profile', 'type' => 'SCREEN', 'xnum' => 0, 'seqn' => 5],
            ['xscreen' => 'AD05', 'title' => 'Access Profile', 'icon' => 'ph ph-shield-check', 'keywords' => 'access,roles,permissions', 'type' => 'SCREEN', 'xnum' => 0, 'seqn' => 6],
            ['xscreen' => 'AD06', 'title' => 'Manage Users', 'icon' => 'ph ph-users', 'keywords' => 'users,management', 'type' => 'SCREEN', 'xnum' => 0, 'seqn' => 7],
            ['xscreen' => 'AD07', 'title' => 'Branch/Business Unit', 'icon' => 'ph ph-buildings', 'keywords' => 'branch,business unit', 'type' => 'SCREEN', 'xnum' => 0, 'seqn' => 8],
            ['xscreen' => 'AD08', 'title' => 'Store/Warehouse', 'icon' => 'ph ph-warehouse', 'keywords' => 'store,warehouse,inventory', 'type' => 'SCREEN', 'xnum' => 0, 'seqn' => 9],
            ['xscreen' => 'AD09', 'title' => 'Terminal', 'icon' => 'ph ph-monitor', 'keywords' => 'terminal,device,pos', 'type' => 'SCREEN', 'xnum' => 0, 'seqn' => 10],
            ['xscreen' => 'AD10', 'title' => 'Floor', 'icon' => 'ph ph-grid-four', 'keywords' => 'floor,layout', 'type' => 'SCREEN', 'xnum' => 0, 'seqn' => 11],
            ['xscreen' => 'AD11', 'title' => 'Table', 'icon' => 'ph ph-table', 'keywords' => 'table,dine,layout', 'type' => 'SCREEN', 'xnum' => 0, 'seqn' => 12],
            ['xscreen' => 'AD12', 'title' => 'Phone Numbers', 'icon' => 'ph ph-phone', 'keywords' => 'phone,contact', 'type' => 'SCREEN', 'xnum' => 0, 'seqn' => 13],
            ['xscreen' => 'AD13', 'title' => 'Opening Hours', 'icon' => 'ph ph-clock', 'keywords' => 'hours,time,settings', 'type' => 'SCREEN', 'xnum' => 0, 'seqn' => 14],
            ['xscreen' => 'AD14', 'title' => 'Store Holiday', 'icon' => 'ph ph-calendar-minus', 'keywords' => 'holiday,calendar,store', 'type' => 'SCREEN', 'xnum' => 0, 'seqn' => 15],
            ['xscreen' => 'AD15', 'title' => 'Charges', 'icon' => 'ph ph-receipt', 'keywords' => 'charges,fees', 'type' => 'SCREEN', 'xnum' => 0, 'seqn' => 16],
            ['xscreen' => 'AD16', 'title' => 'Payment Methods', 'icon' => 'ph ph-credit-card', 'keywords' => 'payment,methods,transaction', 'type' => 'SCREEN', 'xnum' => 0, 'seqn' => 17],
            ['xscreen' => 'AD17', 'title' => 'Transactions', 'icon' => 'ph ph-arrows-left-right', 'keywords' => 'transactions,records', 'type' => 'SCREEN', 'xnum' => 0, 'seqn' => 18],

            // ===== MASTER DATA =====
            ['xscreen' => 'MD01', 'title' => 'Brands', 'icon' => 'ph ph-tag', 'keywords' => 'brands,product', 'type' => 'SCREEN', 'xnum' => 0, 'seqn' => 16],
            ['xscreen' => 'MD02', 'title' => 'Categories', 'icon' => 'ph ph-folders', 'keywords' => 'categories,product', 'type' => 'SCREEN', 'xnum' => 0, 'seqn' => 17],
            ['xscreen' => 'MD03', 'title' => 'Attribute', 'icon' => 'ph ph-sliders-horizontal', 'keywords' => 'attribute,product', 'type' => 'SCREEN', 'xnum' => 0, 'seqn' => 18],
            ['xscreen' => 'MD04', 'title' => 'Attribute Options', 'icon' => 'ph ph-list', 'keywords' => 'attribute options', 'type' => 'SCREEN', 'xnum' => 0, 'seqn' => 19],
            ['xscreen' => 'MD05', 'title' => 'Tags', 'icon' => 'ph ph-hash', 'keywords' => 'tags,labels', 'type' => 'SCREEN', 'xnum' => 0, 'seqn' => 20],
            ['xscreen' => 'MD06', 'title' => 'Product Labels', 'icon' => 'ph ph-sticker', 'keywords' => 'labels,product', 'type' => 'SCREEN', 'xnum' => 0, 'seqn' => 21],
            ['xscreen' => 'MD07', 'title' => 'Product Collections', 'icon' => 'ph ph-archive', 'keywords' => 'collections,product', 'type' => 'SCREEN', 'xnum' => 0, 'seqn' => 22],
            ['xscreen' => 'MD08', 'title' => 'Product Options', 'icon' => 'ph ph-list-dashes', 'keywords' => 'product options', 'type' => 'SCREEN', 'xnum' => 0, 'seqn' => 23],
            ['xscreen' => 'MD09', 'title' => 'Product Specification Groups', 'icon' => 'ph ph-folders', 'keywords' => 'specification groups', 'type' => 'SCREEN', 'xnum' => 0, 'seqn' => 24],
            ['xscreen' => 'MD10', 'title' => 'Product Specification Attributes', 'icon' => 'ph ph-sliders', 'keywords' => 'product specs', 'type' => 'SCREEN', 'xnum' => 0, 'seqn' => 25],
            ['xscreen' => 'MD11', 'title' => 'Product Specification Tables', 'icon' => 'ph ph-table', 'keywords' => 'spec tables', 'type' => 'SCREEN', 'xnum' => 0, 'seqn' => 26],
            ['xscreen' => 'MD12', 'title' => 'Product', 'icon' => 'ph ph-package', 'keywords' => 'product,item', 'type' => 'SCREEN', 'xnum' => 0, 'seqn' => 27],
            ['xscreen' => 'MD13', 'title' => 'Product Addons', 'icon' => 'ph ph-plus-circle', 'keywords' => 'addons,product', 'type' => 'SCREEN', 'xnum' => 0, 'seqn' => 28],
            ['xscreen' => 'MD14', 'title' => 'Flash Sales', 'icon' => 'ph ph-lightning', 'keywords' => 'flash sales', 'type' => 'SCREEN', 'xnum' => 0, 'seqn' => 29],
            ['xscreen' => 'MD15', 'title' => 'Discounts', 'icon' => 'ph ph-percent', 'keywords' => 'discounts,offer', 'type' => 'SCREEN', 'xnum' => 0, 'seqn' => 30],
            ['xscreen' => 'MD16', 'title' => 'Offers', 'icon' => 'ph ph-gift', 'keywords' => 'offers,promotions', 'type' => 'SCREEN', 'xnum' => 0, 'seqn' => 31],
            ['xscreen' => 'MD17', 'title' => 'Reviews', 'icon' => 'ph ph-star', 'keywords' => 'reviews,ratings', 'type' => 'SCREEN', 'xnum' => 0, 'seqn' => 32],


            // ===== PURCHASE =====
            ['xscreen' => 'PO01', 'title' => 'Purchase Order', 'icon' => 'ph ph-file-text', 'keywords' => 'purchase order', 'type' => 'SCREEN', 'xnum' => 0, 'seqn' => 33],
            ['xscreen' => 'PO02', 'title' => 'Purchase Order to GRN', 'icon' => 'ph ph-arrow-square-down', 'keywords' => 'po to grn', 'type' => 'SCREEN', 'xnum' => 0, 'seqn' => 34],
            ['xscreen' => 'PO03', 'title' => 'Direct Purchase', 'icon' => 'ph ph-shopping-cart', 'keywords' => 'direct purchase', 'type' => 'SCREEN', 'xnum' => 0, 'seqn' => 35],
            ['xscreen' => 'PO04', 'title' => 'GRN Process', 'icon' => 'ph ph-truck', 'keywords' => 'grn,goods received', 'type' => 'SCREEN', 'xnum' => 0, 'seqn' => 36],
            ['xscreen' => 'PO05', 'title' => 'Purchase Return (Direct)', 'icon' => 'ph ph-arrow-u-down-left', 'keywords' => 'purchase return direct', 'type' => 'SCREEN', 'xnum' => 0, 'seqn' => 37],
            ['xscreen' => 'PO06', 'title' => 'Purchase Return (GRN)', 'icon' => 'ph ph-arrow-u-down-left', 'keywords' => 'purchase return grn', 'type' => 'SCREEN', 'xnum' => 0, 'seqn' => 38],


            // ===== INVENTORY =====
            ['xscreen' => 'IM01', 'title' => 'Inventory Transfer (Direct)', 'icon' => 'ph ph-arrows-left-right', 'keywords' => 'inventory transfer direct', 'type' => 'SCREEN', 'xnum' => 0, 'seqn' => 39],
            ['xscreen' => 'IM02', 'title' => 'Inventory Transfer (Branch)', 'icon' => 'ph ph-arrows-split', 'keywords' => 'inventory transfer branch', 'type' => 'SCREEN', 'xnum' => 0, 'seqn' => 40],
            ['xscreen' => 'IM03', 'title' => 'Inventory Issue', 'icon' => 'ph ph-warning', 'keywords' => 'inventory issue', 'type' => 'SCREEN', 'xnum' => 0, 'seqn' => 41],
            ['xscreen' => 'IM04', 'title' => 'Inventory Adjustment', 'icon' => 'ph ph-wrench', 'keywords' => 'inventory adjustment', 'type' => 'SCREEN', 'xnum' => 0, 'seqn' => 42],
            ['xscreen' => 'IM05', 'title' => 'Inventory Opening', 'icon' => 'ph ph-door-open', 'keywords' => 'inventory opening', 'type' => 'SCREEN', 'xnum' => 0, 'seqn' => 43],
            ['xscreen' => 'IM06', 'title' => 'Batch Process', 'icon' => 'ph ph-stack', 'keywords' => 'batch process', 'type' => 'SCREEN', 'xnum' => 0, 'seqn' => 44],
            ['xscreen' => 'IM07', 'title' => 'Inventory Conversion', 'icon' => 'ph ph-recycle', 'keywords' => 'inventory conversion', 'type' => 'SCREEN', 'xnum' => 0, 'seqn' => 45],


            // ===== SALES =====
            ['xscreen' => 'SO01', 'title' => 'Sales Order', 'icon' => 'ph ph-shopping-bag', 'keywords' => 'sales order', 'type' => 'SCREEN', 'xnum' => 0, 'seqn' => 46],
            ['xscreen' => 'SO02', 'title' => 'Sales Order to Invoice', 'icon' => 'ph ph-arrow-square-up', 'keywords' => 'so to invoice', 'type' => 'SCREEN', 'xnum' => 0, 'seqn' => 47],
            ['xscreen' => 'SO03', 'title' => 'Direct Invoice', 'icon' => 'ph ph-receipt', 'keywords' => 'direct invoice', 'type' => 'SCREEN', 'xnum' => 0, 'seqn' => 48],
            ['xscreen' => 'SO04', 'title' => 'Invoice Process', 'icon' => 'ph ph-file', 'keywords' => 'invoice process', 'type' => 'SCREEN', 'xnum' => 0, 'seqn' => 49],
            ['xscreen' => 'SO05', 'title' => 'Sales Return (Direct)', 'icon' => 'ph ph-arrow-u-up-left', 'keywords' => 'sales return direct', 'type' => 'SCREEN', 'xnum' => 0, 'seqn' => 50],
            ['xscreen' => 'SO06', 'title' => 'Sales Return (Invoice)', 'icon' => 'ph ph-arrow-u-up-left', 'keywords' => 'sales return invoice', 'type' => 'SCREEN', 'xnum' => 0, 'seqn' => 51],


            // ===== PARTY / ACCOUNTS =====
            ['xscreen' => 'FA01', 'title' => 'Customers', 'icon' => 'ph ph-user', 'keywords' => 'customers', 'type' => 'SCREEN', 'xnum' => 0, 'seqn' => 52],
            ['xscreen' => 'FA02', 'title' => 'Suppliers', 'icon' => 'ph ph-handshake', 'keywords' => 'suppliers', 'type' => 'SCREEN', 'xnum' => 0, 'seqn' => 53],
            ['xscreen' => 'FA03', 'title' => 'Employee', 'icon' => 'ph ph-identification-card', 'keywords' => 'employee,staff', 'type' => 'SCREEN', 'xnum' => 0, 'seqn' => 54],

        ]);
    }
}
