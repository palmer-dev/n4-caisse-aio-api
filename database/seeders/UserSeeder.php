<?php

namespace Database\Seeders;

use App\enums\RolesEnum;
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
        $this->command->getOutput()->progressStart( 2 );

        $user = User::factory()->create( [
            'shop_id'  => Shop::inRandomOrder()->first()->id,
            'email'    => 'test@test.com',
            'password' => bcrypt( 'test' ),
        ] );

        $this->command->getOutput()->progressAdvance();

        $user->assignRole( RolesEnum::ADMIN );

        $this->command->getOutput()->progressFinish();
    }
}
