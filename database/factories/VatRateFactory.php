<?php

namespace Database\Factories;

use App\Models\VatRate;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class VatRateFactory extends Factory
{
	protected $model = VatRate::class;

	public function definition(): array
	{
		return [
			'name'        => $this->faker->name(),
			'description' => $this->faker->text(),
			'value'       => $this->faker->randomFloat(),
			'created_at'  => Carbon::now(),
			'updated_at'  => Carbon::now(),
		];
	}
}
