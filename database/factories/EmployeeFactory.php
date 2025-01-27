<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\Shop;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition(): array
    {
        return [
            'firstname'  => $this->faker->firstName(),
            'lastname'   => $this->faker->lastName(),
            'code'       => $this->faker->unique()->regexify( '[0-9]{5}' ),
            'email'      => $this->faker->unique()->safeEmail(),
            'phone'      => $this->faker->phoneNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'shop_id'    => Shop::inRandomOrder()->first()->id,
        ];
    }
}
