<?php

namespace Database\Factories;

use App\Models\LoyaltyOffer;
use App\Models\Shop;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class LoyaltyOfferFactory extends Factory
{
	protected $model = LoyaltyOffer::class;

	public function definition(): array
	{
		return [
			'points'     => $this->faker->randomNumber(),
			'start_date' => Carbon::now(),
			'end_date'   => Carbon::now(),
			'is_active'  => $this->faker->word(),
			'created_at' => Carbon::now(),
			'updated_at' => Carbon::now(),

			'shop_id' => Shop::factory(),
		];
	}
}
