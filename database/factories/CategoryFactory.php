<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Shop;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $name = $this->faker->name();
        return [
            'name'        => $name,
            'slug'        => \Str::slug( $name ),
            'description' => $this->faker->text(),
            'image'       => null,
            'created_at'  => Carbon::now(),
            'updated_at'  => Carbon::now(),

            'parent_id' => null,
            'shop_id'   => Shop::inRandomOrder()->first()->id,
        ];
    }
}
