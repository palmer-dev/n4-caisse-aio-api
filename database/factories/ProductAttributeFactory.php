<?php

namespace Database\Factories;

use App\Enums\ProductTypeEnum;
use App\Models\Product;
use App\Models\ProductAttribute;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ProductAttributeFactory extends Factory
{
    protected $model = ProductAttribute::class;

    public function definition(): array
    {
        return [
            'name'         => $this->faker->name(),
            'product_type' => $this->faker->randomElement( collect( ProductTypeEnum::cases() )->values()->first() ),
            'created_at'   => Carbon::now(),
            'updated_at'   => Carbon::now(),

            'product_id' => Product::factory(),
        ];
    }
}
