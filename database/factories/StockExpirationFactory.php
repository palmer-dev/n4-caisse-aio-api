<?php

namespace Database\Factories;

use App\Models\StockExpiration;
use App\Models\StockMovements;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class StockExpirationFactory extends Factory
{
	protected $model = StockExpiration::class;

	public function definition(): array
	{
		return [
			'expiration_date' => Carbon::now(),
			'created_at'      => Carbon::now(),
			'updated_at'      => Carbon::now(),

			'stock_movements_id' => StockMovements::factory(),
		];
	}
}
