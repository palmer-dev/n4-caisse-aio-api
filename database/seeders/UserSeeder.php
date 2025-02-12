<?php

namespace Database\Seeders;

use App\Enums\RolesEnum;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = RolesEnum::cases();

        $this->command->getOutput()->progressStart( count( $roles ) );

        foreach ($roles as $role) {
            $user = User::factory()->create( [
                'shop_id'  => Shop::inRandomOrder()->first()->id,
                'email'    => "$role->value@test.com",
                'password' => bcrypt( $role->value ),
            ] );

            $this->command->getOutput()->progressAdvance();

            $user->assignRole( $role );

            $this->command->getOutput()->progressAdvance();
        }

        $this->command->getOutput()->progressFinish();
    }
}
