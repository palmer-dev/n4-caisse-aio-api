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
			'slug'          => $this->faker->slug(),
			'currency_code' => $this->faker->word(),
			'unit_amount'   => $this->faker->randomFloat(),
			'created_at'    => Carbon::now(),
			'updated_at'    => Carbon::now(),

			'product_id' => Product::factory(),
		];
	}
}
