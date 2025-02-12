<?php

namespace App\Http\Resources;

use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Stock */
class StockResource extends JsonResource
{
	public function toArray(Request $request): array
	{
		return [
			'id'         => $this->id,
			'quantity'   => $this->quantity,
			'created_at' => $this->created_at,
			'updated_at' => $this->updated_at,

			'sku_id' => $this->sku_id,

			'sku' => new SkuResource( $this->whenLoaded( 'sku' ) ),
		];
	}
}
