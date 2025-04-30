<?php

namespace Database\Seeders;

use App\Enums\MovementTypeEnum;
use App\Enums\ProductTypeEnum;
use App\Models\Sku;
use App\Models\StockMovements;
use Illuminate\Database\Seeder;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $skus = Sku::all();

        $this->command->getOutput()->progressStart( $skus->count() );

        $skus->each( function (Sku $sku) {
            $movement = $sku->stockMovements()->save( StockMovements::factory()->make( ["movement_type" => MovementTypeEnum::INPUT] ) );
            if ($sku->product->type === ProductTypeEnum::PERISHABLE) {
                $movement->stockExpiration()->create( ["expiration_date" => now()->addDays( 10 )] );;
            }

            $this->command->getOutput()->progressAdvance();
        } );

        $this->command->getOutput()->progressFinish();
    }
}
