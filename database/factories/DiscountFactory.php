<?php

namespace Database\Factories;

use App\Models\Discount;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class DiscountFactory extends Factory
{
	protected $model = Discount::class;

	public function definition(): array
	{
		return [
			'name'       => $this->faker->name(),
			'type'       => $this->faker->word(),
			'value'      => $this->faker->randomFloat(),
			'start_date' => Carbon::now(),
			'end_date'   => Carbon::now(),
			'is_active'  => $this->faker->boolean(),
			'created_at' => Carbon::now(),
			'updated_at' => Carbon::now(),
		];
	}
}
