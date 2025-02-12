<?php

namespace Database\Seeders;

use App\Models\VatRate;
use Illuminate\Database\Seeder;

class VatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        VatRate::factory()->create( ["value" => 5, "description" => "Boissons"] );
        VatRate::factory()->create( ["value" => 10, "description" => "10%"] );
        VatRate::factory()->create( ["value" => 15, "description" => "15%"] );
        VatRate::factory()->create( ["value" => 20, "description" => "TVA Standards"] );
    }
}
