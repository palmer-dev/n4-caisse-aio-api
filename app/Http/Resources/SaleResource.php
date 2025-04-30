<?php

namespace App\Http\Resources;

use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Sale */
class SaleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'discount'    => $this->discount,
            'sub_total'   => $this->sub_total,
            'grand_total' => $this->grand_total,
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at,

            'employee_id' => $this->employee_id,
            'client_id'   => $this->client_id,
            'shop_id'     => $this->shop_id,

            'shop'     => new ShopResource( $this->whenLoaded( 'shop_id' ) ),
            'employee' => new EmployeeResource( $this->whenLoaded( 'employee' ) ),
            'client'   => new ClientResource( $this->whenLoaded( 'client' ) ),
        ];
    }
}
