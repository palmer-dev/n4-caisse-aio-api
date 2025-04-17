<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Shop;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ClientFactory extends Factory
{
    protected $model = Client::class;

    public function definition(): array
    {
        return [
            'firstname'  => $this->faker->firstName(),
            'lastname'   => $this->faker->lastName(),
            'zipcode'    => $this->faker->postcode(),
            'email'      => $this->faker->unique()->safeEmail(),
            'phone'      => $this->faker->phoneNumber(),
            'birthdate'  => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'shop_id' => Shop::inRandomOrder()->first()->id,
        ];
    }
}
