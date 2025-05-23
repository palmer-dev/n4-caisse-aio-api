<?php

namespace App\Http\Resources;

use App\Models\Sku;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Sku */
class SkuResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                   => $this->id,
            'sku'                  => $this->sku,
            'name'                 => $this->getComputedNameAttribute(),
            'currency_code'        => $this->currency_code,
            'unit_amount'          => $this->unit_amount,
            'unit_amount_with_tax' => $this->getUnitAmountWithTaxAttribute(),
            'has_discount'         => $this->getHasDiscountAttribute(),
            'final_price'          => $this->final_price,
            'created_at'           => $this->created_at,
            'updated_at'           => $this->updated_at,

            'product_id' => $this->product_id,

            'product'   => new ProductResource( $this->whenLoaded( 'product' ) ),
            'discounts' => DiscountResource::collection( $this->discounts()->current()->get() ),
        ];
    }
}
