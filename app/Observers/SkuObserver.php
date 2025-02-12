<?php

namespace App\Observers;

use App\Models\Sku;

class SkuObserver
{
    /**
     * Handle the Sku "created" event.
     */
    public function created(Sku $sku): void
    {
        // Handle sync between product attribute and product_id for simplicity with Filament
        if ($sku->product_id === null) {
            // Associer seulement si nécessaire
            $productId = $sku->productAttributeSku->productAttribute->product_id;
            if ($sku->product_id !== $productId) {
                $sku->product()->associate( $productId );
                $sku->save();
            }
        }

        // Handle creation of stock data for the product
        if ($sku->id) {
            $sku->stock()->create( ["quantity" => 0] );
        }
    }

    /**
     * Handle the Sku "updated" event.
     */
    public function updated(Sku $sku): void
    {
        if ($sku->product_attribute_sku_id !== null && $sku->isDirty( "product_attribute_sku_id" )) {
            // Associer seulement si nécessaire
            $productId = $sku->productAttributeSku->productAttribute->product_id;
            if ($sku->product_id !== $productId) {
                $sku->product()->associate( $productId );
                $sku->save();
            }
        }
    }
}
