<?php

namespace Database\Factories;

use App\Enums\MovementTypeEnum;
use App\Models\StockMovements;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class StockMovementsFactory extends Factory
{
    protected $model = StockMovements::class;

    public function definition(): array
    {
        return [
            'quantity'      => $this->faker->randomNumber(4),
            'movement_type' => $this->faker->randomElement( MovementTypeEnum::cases() ),
            'description'   => $this->faker->text(),
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
        ];
    }
}
