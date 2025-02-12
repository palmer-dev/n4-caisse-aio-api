<?php

namespace App\Observers;

use App\Enums\ProductTypeEnum;
use App\Models\Product;

class ProductObserver
{
    /**
     * Handle the Product "updated" event.
     * Remove old variations
     */
    public function updated(Product $product): void
    {
        if ($product->isDirty( "type" )) {
            if ($product->getOriginal( "type" ) === ProductTypeEnum::VARIABLE) {
                $product->productAttributes()
                    ->delete();
            } else {
                $product->sku()
                    ->delete();
            }
        }
    }
}
