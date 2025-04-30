<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Shop;
use Illuminate\Database\Seeder;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->getOutput()->progressStart( 10 );

        for ($i = 0; $i < 10; $i++) {
            $shop = Shop::factory()->create();

            $shop->clients()->createMany( Client::factory()->count( rand( 1, 10 ) )->make()->toArray() );

            $this->command->getOutput()->progressAdvance();
        }

        $this->command->getOutput()->progressFinish();
    }
}
