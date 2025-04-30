<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Sku;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class SkuFactory extends Factory
{
    protected $model = Sku::class;

    public function definition(): array
    {
        return [
            'sku'           => $this->faker->word(),
            'currency_code' => "EUR",
            'barcode'       => $this->faker->ean13(),
            'unit_amount'   => $this->faker->randomFloat( 2, min: 1, max: 100 ),
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
        ];
    }
}
