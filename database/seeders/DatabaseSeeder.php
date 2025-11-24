<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use PHPUnit\Framework\Constraint\Count;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call individual seeders
        $this->call([
            CountriesSeeder::class,
            StatesSeeder::class,
            CitiesSeeder::class,
            BusinessCategorySeeder::class,
            XcodesSeeder::class,
            ScreensSeeder::class,
            MenusSeeder::class,
            MenuScreensSeeder::class,
        ]);
    }
}
