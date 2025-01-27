<?php

namespace Database\Factories;

use App\Models\Shop;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ShopFactory extends Factory
{
	protected $model = Shop::class;

	public function definition(): array
	{
		return [
			'name'       => $this->faker->name(),
			'created_at' => Carbon::now(),
			'updated_at' => Carbon::now(),
		];
	}
}
