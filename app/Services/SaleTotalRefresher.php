<?php

namespace App\Services;

use App\Models\Sale;

class SaleTotalRefresher
{
    public function refresh(Sale $sale): void
    {
        $totals = $sale->details()
            ->selectRaw( 'SUM(unit_price * quantity) as computed_sub_total' )
            ->selectRaw( 'SUM(unit_price * (1 + (vat / 100)) * quantity) as computed_grand_total' )
            ->first();

        $sale->sub_total   = $totals->computed_sub_total / 100;
        $sale->grand_total = $totals->computed_grand_total / 100;

        $sale->save();
    }
}
