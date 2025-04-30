<?php

namespace App\Observers;

use App\Enums\MovementTypeEnum;
use App\Models\SaleDetail;

class SaleObserver
{
    /**
     * Handle the SaleDetail "created" event.
     */
    public function created(SaleDetail $saleDetail): void
    {
        // Handle stock
        $sale_no = $saleDetail->sale->sale_no;
        $saleDetail->sku->stockMovements()->create( [
            "quantity"      => $saleDetail->quantity,
            "movement_type" => MovementTypeEnum::OUTPUT,
            "description"   => "Output related to sale: $sale_no"
        ] );
    }

    /**
     * Handle the SaleDetail "updated" event.
     */
    public function updated(SaleDetail $saleDetail): void
    {
        $diff = $saleDetail->quantity - $saleDetail->getOriginal( "quantity" );

        if ($saleDetail->isDirty( "quantity" )) {
            $sale_no = $saleDetail->sale->sale_no;
            $saleDetail->sku->stockMovements()->create( [
                "quantity"      => abs( $diff ),
                "movement_type" => $diff < 0 ? MovementTypeEnum::INPUT : MovementTypeEnum::OUTPUT,
                "description"   => "Edit for the sale: $sale_no"
            ] );
        }
    }

    /**
     * Handle the SaleDetail "deleted" event.
     */
    public function deleted(SaleDetail $saleDetail): void
    {
        $sale_no = $saleDetail->sale->sale_no;
        $saleDetail->sku->stockMovements()->create( [
            "quantity"      => $saleDetail->quantity,
            "movement_type" => MovementTypeEnum::INPUT,
            "description"   => "Delete for the sale: $sale_no"
        ] );
    }

    /**
     * Handle the SaleDetail "restored" event.
     */
    public function restored(SaleDetail $saleDetail): void
    {
        $sale_no = $saleDetail->sale->sale_no;
        $saleDetail->sku->stockMovements()->create( [
            "quantity"      => $saleDetail->quantity,
            "movement_type" => MovementTypeEnum::OUTPUT,
            "description"   => "Restore for the sale: $sale_no"
        ] );
    }

    /**
     * Handle the SaleDetail "force deleted" event.
     */
    public function forceDeleted(SaleDetail $saleDetail): void
    {
        $sale_no = $saleDetail->sale->sale_no;
        $saleDetail->sku->stockMovements()->create( [
            "quantity"      => $saleDetail->quantity,
            "movement_type" => MovementTypeEnum::INPUT,
            "description"   => "Delete for the sale: $sale_no"
        ] );
    }
}
