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
        $this->command->getOutput()->progressStart( 4 );

        $user = User::factory()->create( [
            'shop_id'  => Shop::inRandomOrder()->first()->id,
            'email'    => 'admin@test.com',
            'password' => bcrypt( 'admin' ),
        ] );

        $this->command->getOutput()->progressAdvance();

        $user->assignRole( RolesEnum::ADMIN );

        $user = User::factory()->create( [
            'shop_id'  => Shop::inRandomOrder()->first()->id,
            'email'    => 'shop@test.com',
            'password' => bcrypt( 'shop' ),
        ] );

        $this->command->getOutput()->progressAdvance();

        $user->assignRole( RolesEnum::MANAGER );

        $this->command->getOutput()->progressFinish();
    }
}
