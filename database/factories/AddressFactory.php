<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Shop;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class AddressFactory extends Factory
{
	protected $model = Address::class;

	public function definition(): array
	{
		return [
			'street'      => $this->faker->streetName(),
			'city'        => $this->faker->city(),
			'state'       => $this->faker->word(),
			'postal_code' => $this->faker->postcode(),
			'country'     => $this->faker->country(),
			'created_at'  => Carbon::now(),
			'updated_at'  => Carbon::now(),

			'shop_id' => Shop::factory(),
		];
	}
}
