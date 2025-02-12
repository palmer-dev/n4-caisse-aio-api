<?php

namespace Database\Factories;

use App\Models\Sku;
use App\Models\StockMovements;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class StockMovementsFactory extends Factory
{
	protected $model = StockMovements::class;

	public function definition(): array
	{
		return [
			'quantity'      => $this->faker->randomNumber(),
			'movement_type' => $this->faker->word(),
			'description'   => $this->faker->text(),
			'created_at'    => Carbon::now(),
			'updated_at'    => Carbon::now(),

			'sku_id' => Sku::factory(),
		];
	}
}
