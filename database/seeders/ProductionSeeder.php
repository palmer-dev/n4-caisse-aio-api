<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductionSeeder extends Seeder
{
    /**
     * Run the database seeds.
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
        ] );
    }
}
