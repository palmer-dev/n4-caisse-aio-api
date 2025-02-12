<?php

namespace Database\Factories;

use App\Models\Sku;
use App\Models\Stock;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class StockFactory extends Factory
{
	protected $model = Stock::class;

	public function definition(): array
	{
		return [
			'quantity'   => $this->faker->randomNumber(),
			'created_at' => Carbon::now(),
			'updated_at' => Carbon::now(),

			'sku_id' => Sku::factory(),
		];
	}
}
