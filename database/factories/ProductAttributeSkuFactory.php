<?php

namespace Database\Factories;

use App\Models\ProductAttributeSku;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ProductAttributeSkuFactory extends Factory
{
    protected $model = ProductAttributeSku::class;

    public function definition(): array
    {
        return [
            'value'      => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
