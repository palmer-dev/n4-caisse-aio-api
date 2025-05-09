<?php

namespace App\Http\Resources;

use App\Enums\RolesEnum;
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

            $this->mergeWhen( !$this->relationLoaded( 'employee' ) && auth()->user()->hasRole( RolesEnum::ADMIN ), [
                'employee_id' => $this->employee_id,
            ] ),
            $this->mergeWhen( !$this->relationLoaded( 'client' ) && auth()->user()->hasRole( RolesEnum::ADMIN ), [
                'client_id' => $this->client_id,
            ] ),
            $this->mergeWhen( !$this->relationLoaded( 'shop' ) && auth()->user()->hasRole( RolesEnum::ADMIN ), [
                'shop_id' => $this->shop_id,
            ] ),

            'shop'     => new ShopResource( $this->whenLoaded( 'shop' ) ),
            'employee' => new EmployeeResource( $this->whenLoaded( 'employee' ) ),
            'client'   => new ClientResource( $this->whenLoaded( 'client' ) ),

            'created_at' => $this->created_at,
        ];
    }
}
