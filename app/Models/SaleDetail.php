<?php

namespace App\Models;

use App\Casts\MoneyCast;
use App\Enums\ProductTypeEnum;
use App\Observers\SaleObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

#[ObservedBy(SaleObserver::class)]
class SaleDetail extends Model
{
    use HasUuids, HasFactory;

    protected $fillable = [
        'sale_id',
        'sku_id',
        'quantity',
        'unit_price',
        'vat',
    ];

    protected $casts = [
        "unit_price" => MoneyCast::class,
    ];

    public function shop(): HasOneThrough
    {
        return $this->hasOneThrough(
            Shop::class,     // Le modèle final
            Sale::class,     // Le modèle intermédiaire
            'id',            // Clé sur Sale (intermédiaire) qui est référencée par sale_id dans SaleDetail
            'id',            // Clé sur Shop (final) qui est référencée par shop_id dans Sale
            'sale_id',       // Clé sur SaleDetail (courant) vers Sale
            'shop_id'        // Clé sur Sale (intermédiaire) vers Shop
        );
    }

    public function sale(): BelongsTo
    {
        return $this->belongsTo( Sale::class );
    }

    public function sku(): BelongsTo
    {
        return $this->belongsTo( Sku::class );
    }

    public function getDenominationAttribute(): string
    {
        if ($this->sku->product->type === ProductTypeEnum::VARIABLE) {
            return $this->sku->product->name . " - " . $this->sku->productAttributeSku->value;

        }
        return $this->sku->product->name;
    }

    public function getSubTotalAttribute(): float
    {
        return $this->unit_price * $this->quantity;
    }

    public function getGrandTotalAttribute(): float
    {
        return $this->unit_price * (1 + ($this->vat / 100)) * $this->quantity;
    }

    public function getVatAmountAttribute(): float
    {
        return $this->unit_price * $this->quantity * $this->vat;
    }
}
