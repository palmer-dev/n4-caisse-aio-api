<?php

namespace App\Http\Resources;

use App\Models\StockMovements;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin StockMovements */
class StockMovementsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'quantity'      => $this->quantity,
            'movement_type' => $this->movement_type,
            'description'   => $this->description,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,

            'sku_id' => $this->sku_id,

            'sku' => new SkuResource( $this->whenLoaded( 'sku' ) ),

            'product' => new ProductResource( $this->whenLoaded( 'product' ) ),
        ];
    }
}
