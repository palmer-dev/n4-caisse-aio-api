<?php

namespace App\Models;

use App\Casts\MoneyCast;
use App\Enums\DiscountType;
use App\Models\Scopes\ByShop;
use App\Observers\SkuObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy(SkuObserver::class)]
#[ScopedBy(ByShop::class)]
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

    protected $casts = [
        "unit_amount" => MoneyCast::class,
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
        return $this->hasMany( StockMovements::class );
    }

    public function shop(): HasOneThrough
    {
        return $this->hasOneThrough(
            Shop::class,
            Product::class,
            'id',
            'id',
            'product_id',
            'shop_id'
        );
    }

    public function discounts(): BelongsToMany
    {
        return $this->belongsToMany( Discount::class );
    }

    public function getComputedNameAttribute(): string
    {
        return $this->product->name . ($this->productAttributeSku ? " - {$this->productAttributeSku->value}" : '');
    }

    public function getFinalPriceAttribute()
    {
        $price = $this->unit_amount * (1 + $this->product->vatRate->value / 100);
        $promo = $this->discounts()
            ->current()
            ->first();

        if ($promo) {
            $price = $promo->type === DiscountType::PERCENT
                ? $price * (1 - $promo->value / 100)
                : max( 0, $price - $promo->value );
        }

        return $price;
    }

    public function getDiscountValueAttribute()
    {
        $price = $this->unit_amount * (1 + $this->product->vatRate->value / 100);

        $value = 0;

        $promo = $this->discounts()
            ->current()
            ->first();

        if ($promo) {
            $value = $promo->type === DiscountType::PERCENT
                ? $price * ($promo->value / 100)
                : min( $promo->value, $price );
        }

        return $value;
    }
}
