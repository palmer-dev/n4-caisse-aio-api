<?php

namespace Database\Factories;

use App\Models\SaleDetail;
use App\Models\Sku;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class SaleDetailFactory extends Factory
{
    protected $model = SaleDetail::class;

    public function definition(): array
    {
        $sku = Sku::inRandomOrder()->first();
        return [
            'unit_price' => $sku->unit_amount, // Multiply by 100 to have the price in cents
            'quantity'   => intval( abs( $this->faker->randomFloat( 0, 1, 5 ) ) ),
            'vat'        => $this->faker->randomFloat( 2, 0, 100 ),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'sku_id' => $sku->id,
        ];
    }
}
