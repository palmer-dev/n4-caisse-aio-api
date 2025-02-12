<?php

namespace App\Http\Resources;

use App\Models\ProductAttributeSku;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin ProductAttributeSku */
class ProductAttributeSkuResource extends JsonResource
{
	public function toArray(Request $request): array
	{
		return [
			'id'         => $this->id,
			'value'      => $this->value,
			'created_at' => $this->created_at,
			'updated_at' => $this->updated_at,

			'product_attribute_id' => $this->product_attribute_id,
			'sku_id'               => $this->sku_id,

			'productAttribute' => new ProductAttributeResource( $this->whenLoaded( 'productAttribute' ) ),
			'sku'              => new SkuResource( $this->whenLoaded( 'sku' ) ),
		];
	}
}
