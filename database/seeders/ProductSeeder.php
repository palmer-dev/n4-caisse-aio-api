<?php

namespace Database\Seeders;

use App\Enums\ProductTypeEnum;
use App\Models\Product;
use App\Models\Sku;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->getOutput()->progressStart( 20 );

        Product::factory()->count( 20 )->create()
            ->each( function ($product) {
                if ($product->type === ProductTypeEnum::VARIABLE) {
                    for ($j = 0; $j < rand( 1, 3 ); $j++) {
                        $attribute = $product->productAttributes()->create( [
                            "name" => fake()->word,
                        ] );
                        for ($i = 0; $i < rand( 1, 3 ); $i++) {
                            $prdtSku = $attribute->productAttributeSkus()->create( [
                                "value" => fake()->word,
                            ] );

                            $prdtSku->sku()->save( Sku::factory()->make() );
                        }
                    }
                } else {
                    $product->sku()->save( Sku::factory()->make() );
                }
                $this->command->getOutput()->progressAdvance();
            } );

        $this->command->getOutput()->progressFinish();
    }
}
