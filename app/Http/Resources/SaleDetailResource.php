<?php

namespace App\Http\Resources;

use App\Models\SaleDetail;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin SaleDetail */
class SaleDetailResource extends JsonResource
{
	public function toArray(Request $request): array
	{
		return [
			'id'         => $this->id,
			'quantity'   => $this->quantity,
			'unit_price' => $this->unit_price,
			'vat'        => $this->vat,
			'created_at' => $this->created_at,
			'updated_at' => $this->updated_at,

			'sale_id' => $this->sale_id,
			'sku_id'  => $this->sku_id,

			'sale' => new SaleResource( $this->whenLoaded( 'sale' ) ),
			'sku'  => new SkuResource( $this->whenLoaded( 'sku' ) ),
		];
	}
}
