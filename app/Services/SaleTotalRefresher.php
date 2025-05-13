<?php

namespace App\Services;

use App\Enums\DiscountType;
use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Carbon;

class SaleTotalRefresher
{
    public function refresh(Sale $sale): void
    {
        // Refresh VAT rate on sale details
        $sale->details()->each( fn(SaleDetail $detail) => $detail->update( [
            "unit_price" => $detail->sku->unit_amount,
            "vat"        => $detail->sku->product->vatRate->value
        ] ) );

        $now = Carbon::now();

        // Compute totals
        $totals = $sale->details()
            ->leftJoin( 'skus', 'skus.id', '=', 'sale_details.sku_id' )
            ->leftJoin( 'discount_sku', 'discount_sku.sku_id', '=', 'sale_details.sku_id' )
            ->leftJoin( 'discounts', function ($join) use ($now) {
                $join->on( 'discounts.id', '=', 'discount_sku.discount_id' )
                    ->where( 'discounts.is_active', true )
                    ->where( function (JoinClause $query) use ($now) {
                        $query->whereNull( 'discounts.start_date' )
                            ->orWhereDate( 'discounts.start_date', '<=', $now );
                    } )
                    ->where( function (JoinClause $query) use ($now) {
                        $query->whereNull( 'discounts.end_date' )
                            ->orWhereDate( 'discounts.end_date', '>=', $now );
                    } );
            } )
            ->selectRaw( 'SUM(skus.unit_amount * sale_details.quantity) AS computed_sub_total' )
            ->selectRaw( '
        SUM(
            CASE
                WHEN discounts.type = "' . DiscountType::PERCENT->value . '" THEN (skus.unit_amount * (1 + vat / 100) * (1 - discounts.value / 10000)) * quantity
                WHEN discounts.type = "' . DiscountType::AMOUNT->value . '" THEN (skus.unit_amount * (1 + vat / 100) - discounts.value) * quantity
                ELSE skus.unit_amount * (1 + vat / 100) * quantity
            END
        ) AS computed_grand_total
    ' )
            ->selectRaw( '
        SUM(
            CASE
                WHEN discounts.type = "' . DiscountType::PERCENT->value . '" THEN (skus.unit_amount * (1 + vat / 100) * (discounts.value / 10000)) * quantity
                WHEN discounts.type = "' . DiscountType::AMOUNT->value . '" THEN discounts.value * quantity
                ELSE skus.unit_amount * (1 + vat / 100) * quantity
            END
        ) AS computed_discount
    ' )
            ->first();

        // Update sale totals
        $sale->sub_total   = $totals->computed_sub_total / 100;
        $sale->grand_total = ($totals->computed_grand_total / 100);
        $sale->discount = ($totals->computed_discount / 100);

        $sale->save();
    }
}
