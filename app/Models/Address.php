<?php

namespace App\Models;

use App\Enums\AddressTypeEnum;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    use HasUuids, HasFactory;

    protected $fillable = [
        'street',
        'city',
        'state',
        'postal_code',
        'country',
        'shop_id',
        'type',
    ];

    protected $casts = [
        "type" => AddressTypeEnum::class
    ];

    public function shop(): BelongsTo
    {
        return $this->belongsTo( Shop::class );
    }

    public function getLineAttribute(): string
    {
        return "$this->street, $this->postal_code $this->city, $this->state $this->country";
    }
}
