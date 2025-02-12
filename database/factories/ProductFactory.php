<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\Shop;
use App\Models\VatRate;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ProductFactory extends Factory
{
	protected $model = Product::class;

	public function definition(): array
	{
		return [
			'type'        => $this->faker->word(),
			'name'        => $this->faker->name(),
			'slug'        => $this->faker->slug(),
			'description' => $this->faker->text(),
			'created_at'  => Carbon::now(),
			'updated_at'  => Carbon::now(),

			'category_id' => Category::inRandomOrder()->first()->id,
			'vat_rate_id' => VatRate::inRandomOrder()->first()->id,
			'shop_id'     => Shop::inRandomOrder()->first()->id,
		];
	}
}
