<?php

namespace App\Http\Resources;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Client */
class ClientResource extends JsonResource
{
	public function toArray(Request $request): array
	{
		return [
			'id'         => $this->id,
			'firstname'  => $this->firstname,
			'lastname'   => $this->lastname,
			'zipcode'    => $this->zipcode,
			'email'      => $this->email,
			'phone'      => $this->phone,
			'birthdate'  => $this->birthdate,
			'created_at' => $this->created_at,
			'updated_at' => $this->updated_at,
		];
	}
}
