<?php

namespace App\Http\Resources;

use App\Models\ProductAttribute;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin ProductAttribute */
class ProductAttributeResource extends JsonResource
{
	public function toArray(Request $request): array
	{
		return [
			'id'           => $this->id,
			'name'         => $this->name,
			'product_type' => $this->product_type,
			'created_at'   => $this->created_at,
			'updated_at'   => $this->updated_at,

			'product_id' => $this->product_id,

			'product' => new ProductResource( $this->whenLoaded( 'product' ) ),
		];
	}
}
