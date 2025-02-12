<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Product */
class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'type'        => $this->type,
            'name'        => $this->name,
            'slug'        => $this->slug,
            'description' => $this->description,
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at,

            'category_id' => $this->category_id,
            'vat_rate_id' => $this->vat_rate_id,
            'shop_id'     => $this->shop_id,

            'category' => new CategoryResource( $this->whenLoaded( 'category' ) ),
            'vatRate'  => new VatRateResource( $this->whenLoaded( 'vatRate' ) ),
            'shop'     => new VatRateResource( $this->whenLoaded( 'shop' ) ),

            'stock'              => new VatRateResource( $this->whenLoaded( 'stock' ) ),
            'sku'                => new VatRateResource( $this->whenLoaded( 'sku' ) ),
            'product_attributes' => new VatRateResource( $this->whenLoaded( 'productAttributes' ) ),
        ];
    }
}
