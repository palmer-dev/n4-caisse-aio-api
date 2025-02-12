<?php

namespace App\Http\Resources;

use App\Models\LoyaltyOffer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin LoyaltyOffer */
class LoyaltyOfferResource extends JsonResource
{
	public function toArray(Request $request): array
	{
		return [
			'id'         => $this->id,
			'points'     => $this->points,
			'start_date' => $this->start_date,
			'end_date'   => $this->end_date,
			'is_active'  => $this->is_active,
			'created_at' => $this->created_at,
			'updated_at' => $this->updated_at,

			'shop_id' => $this->shop_id,

			'shop' => new ShopResource( $this->whenLoaded( 'shop' ) ),
		];
	}
}
