<?php

namespace Database\Seeders;

use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Shop;
use App\Services\ReceiptService;
use App\Services\SaleTotalRefresher;
use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $shops = Shop::all();

        $this->command->getOutput()->progressStart( $shops->count() );

        foreach ($shops as $shop) {
            foreach (range( 1, 10 ) as $i) {
                $sale = Sale::factory()->create( [
                    "shop_id" => $shop->id,
                ] );

                $sale->details()->createMany(
                    SaleDetail::factory()->count( rand( 1, 5 ) )
                        ->forShop( $shop )
                        ->make()->toArray()
                );

                $refresher = new SaleTotalRefresher();
                $receipt   = new ReceiptService();
                $refresher->refresh( $sale );
                $receipt->generatePDF( $sale );
            }

            $this->command->getOutput()->progressAdvance();
        }

        $this->command->getOutput()->progressFinish();
    }
}
