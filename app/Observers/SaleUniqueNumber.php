<?php

namespace App\Observers;

use App\Models\Sale;

class SaleUniqueNumber
{
    /**
     * Generate automatically the nes sale number
     * @param Sale $sale
     * @return void
     */
    public function creating(Sale $sale): void
    {
        $year  = $sale->created_at?->year ?? date( 'Y' );   // Année en cours
        $month = $sale->created_at?->month ?? date( 'm' );  // Mois en cours

        // Compter les ventes existantes pour ce shop dans l'année et le mois en cours
        $count = Sale::where( 'shop_id', $sale->shop_id )
                ->whereYear( 'created_at', $year )
                ->whereMonth( 'created_at', $month )
                ->count() + 1;

        // Format du numéro de vente
        $sale->sale_no = 'V-' . $year . $month . str_pad( $count, 6, '0', STR_PAD_LEFT );
    }
}
