<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuScreensSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Adminstration Menu Screens
        $M100 = Menu::where('business_id', null)->where('xmenu', 'M100')->first();
        if ($M100) {
            $screens = DB::table('screens')
                ->whereIn('xscreen', [
                    'DASH'
                ])
                ->pluck('id');

            $seq = 1;
            foreach ($screens as $sid) {
                $M100->screens()->attach($sid, [
                    'business_id'     => null, // or your actual business id
                    'alternate_title' => null,
                    'seqn'            =>  $seq // set sequence as needed
                ]);
                $seq++;
            }
        }

        // Administratation
        $M101 = Menu::where('business_id', null)->where('xmenu', 'M101')->first();
        if ($M101) {
            $screens = DB::table('screens')
                ->whereIn('xscreen', [
                    'AD01','AD02','AD03','AD04','AD05','AD06','AD07','AD08','AD09','AD10','AD11','AD12','AD13','AD14'
                ])
                ->pluck('id');

            $seq = 1;
            foreach ($screens as $sid) {
                $M101->screens()->attach($sid, [
                    'business_id'     => null, // or your actual business id
                    'alternate_title' => null,
                    'seqn'            =>  $seq // set sequence as needed
                ]);
                $seq++;
            }
        }

        // Master Data
        $M102 = Menu::where('business_id', null)->where('xmenu', 'M102')->first();
        if ($M102) {
            $screens = DB::table('screens')
                ->whereIn('xscreen', [
                    'MD01','MD02','MD03','MD04','MD05','MD06','MD07','MD08','MD09','MD10','MD11','MD12','MD13','MD14','MD15','MD16','MD17',
                ])
                ->pluck('id'); 

            $seq = 1;
            foreach ($screens as $sid) {
                $M102->screens()->attach($sid, [
                    'business_id'     => null, // or your actual business id
                    'alternate_title' => null,
                    'seqn'            =>  $seq // set sequence as needed
                ]);
                $seq++;
            }
        }

        // Accounting
        $M201 = Menu::where('business_id', null)->where('xmenu', 'M201')->first();
        if ($M201) {
            $screens = DB::table('screens')
                ->whereIn('xscreen', [
                    'FA01','FA02','FA03',
                ])
                ->pluck('id');

            $seq = 1;
            foreach ($screens as $sid) {
                $M201->screens()->attach($sid, [
                    'business_id'     => null, // or your actual business id
                    'alternate_title' => null,
                    'seqn'            =>  $seq // set sequence as needed
                ]);
                $seq++;
            }
        }


        // Procurement
        $M301 = Menu::where('business_id', null)->where('xmenu', 'M301')->first();
        if ($M301) {
            $screens = DB::table('screens')
                ->whereIn('xscreen', [
                    'PO01','PO02','PO03','PO04','PO05','PO06',
                ])
                ->pluck('id');

            $seq = 1;
            foreach ($screens as $sid) {
                $M301->screens()->attach($sid, [
                    'business_id'     => null, // or your actual business id
                    'alternate_title' => null,
                    'seqn'            =>  $seq // set sequence as needed
                ]);
                $seq++;
            }
        }


        // Sales
        $M401 = Menu::where('business_id', null)->where('xmenu', 'M401')->first();
        if ($M401) {
            $screens = DB::table('screens')
                ->whereIn('xscreen', [
                    'SO01','SO02','SO03','SO04','SO05','SO06',
                ])
                ->pluck('id');

            $seq = 1;
            foreach ($screens as $sid) {
                $M401->screens()->attach($sid, [
                    'business_id'     => null, // or your actual business id
                    'alternate_title' => null,
                    'seqn'            =>  $seq // set sequence as needed
                ]);
                $seq++;
            }
        }


        // Inventory
        $M501 = Menu::where('business_id', null)->where('xmenu', 'M501')->first();
        if ($M501) {
            $screens = DB::table('screens')
                ->whereIn('xscreen', [
                    'IM01','IM02','IM03','IM04','IM05','IM06','IM07',
                ])
                ->pluck('id');

            $seq = 1;
            foreach ($screens as $sid) {
                $M501->screens()->attach($sid, [
                    'business_id'     => null, // or your actual business id
                    'alternate_title' => null,
                    'seqn'            =>  $seq // set sequence as needed
                ]);
                $seq++;
            }
        }


    }
}
