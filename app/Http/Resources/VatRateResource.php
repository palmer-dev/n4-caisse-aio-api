<?php

namespace App\Http\Resources;

use App\Models\VatRate;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin VatRate */
class VatRateResource extends JsonResource
{
	public function toArray(Request $request): array
	{
		return [
			'id'          => $this->id,
			'name'        => $this->name,
			'description' => $this->description,
			'value'       => $this->value,
			'created_at'  => $this->created_at,
			'updated_at'  => $this->updated_at,
		];
	}
}
