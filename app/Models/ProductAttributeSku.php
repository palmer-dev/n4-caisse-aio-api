<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductAttributeSku extends Model
{
    use HasUuids, HasFactory, SoftDeletes;

    protected $fillable = [
        'product_attribute_id',
        'value',
    ];

    public function productAttribute(): BelongsTo
    {
        return $this->belongsTo( ProductAttribute::class );
    }

    public function sku(): HasOne
    {
        return $this->hasOne( Sku::class );
    }
}
