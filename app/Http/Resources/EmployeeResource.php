<?php

namespace App\Http\Resources;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Employee */
class EmployeeResource extends JsonResource
{
	public function toArray(Request $request): array
	{
		return [
			'id'         => $this->id,
			'firstname'  => $this->firstname,
			'lastname'   => $this->lastname,
			'email'      => $this->email,
			'phone'      => $this->phone,
			'code'       => $this->code,
			'created_at' => $this->created_at,
			'updated_at' => $this->updated_at,

			'shop_id' => $this->shop_id,

			'shop' => new ShopResource( $this->whenLoaded( 'shop' ) ),
		];
	}
}
