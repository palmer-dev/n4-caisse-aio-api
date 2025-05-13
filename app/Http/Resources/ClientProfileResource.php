<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin User */
class ClientProfileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'firstname' => $this->firstname,
            'lastname'  => $this->lastname,
            'email'     => $this->email,
            'phone'     => $this->phone,
            'shops'     => ClientShopResource::collection( $this->whenLoaded( 'clientShops' ) ),
            'clients'   => ClientResource::collection( $this->whenLoaded( 'clients' ) ),
        ];
    }
}
