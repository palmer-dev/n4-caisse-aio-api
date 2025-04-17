<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call( [
            RolesAndPermissionsSeeder::class,
            ShopSeeder::class,
            UserSeeder::class,
            EmployeeSeeder::class,
            CategorySeeder::class,
            VatSeeder::class,
            ProductSeeder::class,
            StockSeeder::class,
            SaleSeeder::class,
        ] );
    }
}
