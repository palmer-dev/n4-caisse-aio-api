<?php

namespace App\Services;

use App\Models\Sku;

class SimulationService
{
    public function compute(array $skus): array
    {
        // Indexer les quantités par SKU pour un accès rapide
        $quantities = collect( $skus )->pluck( 'quantity', 'sku' );

        // Récupérer les SKUs depuis la base avec leurs relations
        $skuModels = Sku::with( 'product.vatRate' )
            ->whereIn( 'sku', $quantities->keys() )
            ->get();

        $subtotal     = 0;
        $taxTotal     = 0;
        $taxBreakdown = [];

        $skuModels->each( function (Sku $sku) use (&$subtotal, &$taxTotal, &$taxBreakdown, $quantities) {
            $quantity  = $quantities[$sku->sku] ?? 1;
            $unitPrice = $sku->unit_amount;
            $vatRate   = $sku->product->vatRate->value ?? 0;

            $lineSubtotal = $unitPrice * $quantity;
            $lineTax      = ($lineSubtotal * $vatRate) / 100;

            $subtotal += $lineSubtotal;
            $taxTotal += $lineTax;

            // Agrégation par taux de TVA
            if (!isset( $taxBreakdown[$vatRate] )) {
                $taxBreakdown[$vatRate] = 0;
            }

            $taxBreakdown[$vatRate] += $lineTax;
        } );

        $grandTotal = $subtotal + $taxTotal;

        return [
            'subtotal'      => round( $subtotal, 2 ),
            'tax'           => round( $taxTotal, 2 ),
            'grand_total'   => round( $grandTotal, 2 ),
            'tax_breakdown' => collect( $taxBreakdown )
                ->map( fn($amount) => round( $amount, 2 ) )
                ->sortKeys()
                ->toArray()
        ];
    }
}
