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
        VatRate::factory()->create( [
            "name"        => "5% - Boissons",
            "value"       => 5,
            "description" => "Boissons"
        ] );
        VatRate::factory()->create( [
            "name"        => "10%",
            "value"       => 10,
            "description" => "10%"
        ] );
        VatRate::factory()->create( [
            "name"        => "15%",
            "value"       => 15,
            "description" => "15%"
        ] );
        VatRate::factory()->create( [
            "name"        => "20% - Standard VAT",
            "value"       => 20,
            "description" => "Standard VAT"
        ] );
    }
}
