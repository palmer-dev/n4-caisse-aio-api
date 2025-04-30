<?php

namespace Database\Factories;

use App\Models\Sale;
use App\Models\Shop;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class SaleFactory extends Factory
{
    protected $model = Sale::class;

    public function definition(): array
    {
        $shop = Shop::inRandomOrder()->first();
        return [
            'discount'    => $this->faker->randomFloat( max: 15 ),
            'sub_total'   => 0,
            'grand_total' => 0,
            'created_at'  => $this->faker->dateTimeBetween( "-12 month" ),
            'updated_at'  => Carbon::now(),

            'employee_id' => $shop->employees()->inRandomOrder()->first()?->id,
            'client_id'   => $shop->clients()->inRandomOrder()->first()?->id,
            'shop_id'     => $shop->id,
        ];
    }
}
