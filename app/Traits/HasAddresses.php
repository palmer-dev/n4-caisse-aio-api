<?php

namespace App\Traits;

namespace App\Traits;

use App\Enums\AddressTypeEnum;
use App\Models\Address;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait HasAddresses
{
    /**
     * Relation : A model can have multiple addresses
     */
    public function addresses(): HasMany
    {
        return $this->hasMany( Address::class );
    }

    /**
     * Relation : A model can have only one primary address
     */
    public function primaryAddress(): HasOne
    {
        return $this->addresses()
            ->withAttributes( ["type" => AddressTypeEnum::PRIMARY] )
            ->one();
    }

    /**
     * Relation : A model can have only one primary address
     */
    public function billingAddress(): HasOne
    {
        return $this->addresses()
            ->withAttributes( ["type" => AddressTypeEnum::BILLING] )
            ->one();
    }

    /**
     * Relation : A model can have only one primary address
     */
    public function shippingAddress(): HasOne
    {
        return $this->addresses()
            ->withAttributes( ["type" => AddressTypeEnum::SHIPPING] )
            ->one();
    }
}

