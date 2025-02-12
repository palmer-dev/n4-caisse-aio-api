<?php

namespace App\Models;

use App\Observers\SkuObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy(SkuObserver::class)]
class Sku extends Model
{
    use HasUuids, HasFactory, SoftDeletes;

    protected $fillable = [
        'product_attribute_sku_id',
        'product_id',
        'sku',
        'currency_code',
        'unit_amount',
    ];

    public function productAttributeSku(): BelongsTo
    {
        return $this->belongsTo( ProductAttributeSku::class );
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo( Product::class );
    }

    public function getRelatedProductAttribute(): Product
    {
        return $this->product ?? $this->productAttributeSku->productAttribute->product;
    }

    public function stock(): HasOne
    {
        return $this->hasOne( Stock::class );
    }

    public function stockMovements(): HasMany
    {
        return $this->hasMany( StockMovements::make() );
    }
}
