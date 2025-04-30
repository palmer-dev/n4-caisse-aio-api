<?php

namespace App\Models;

use App\Enums\ProductTypeEnum;
use App\Models\Scopes\ByShop;
use App\Observers\ProductObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Staudenmeir\EloquentHasManyDeep\HasManyDeep;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

#[ObservedBy(ProductObserver::class)]
#[ScopedBy(ByShop::class)]
class Product extends Model
{
    use HasUuids, HasFactory, SoftDeletes, HasRelationships;

    protected $fillable = [
        'category_id',
        'vat_rate_id',
        'shop_id',
        'type',
        'name',
        'slug',
        'description',
    ];

    protected $casts = [
        "type" => ProductTypeEnum::class
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo( Category::class );
    }

    public function vatRate(): BelongsTo
    {
        return $this->belongsTo( VatRate::class );
    }

    public function shop(): BelongsTo
    {
        return $this->belongsTo( Shop::class );
    }

    public function productAttributes(): HasMany
    {
        return $this->hasMany( ProductAttribute::class );
    }

    public function getMinPriceAttribute(): string
    {
        if (empty( $this->sku )) {
            dd( $this );
        }
        return ($this->type === ProductTypeEnum::VARIABLE ? $this->skus->min( 'unit_amount' ) : $this->sku->unit_amount) ?? 0;
    }

    public function getMaxPriceAttribute(): string
    {
        return ($this->type === ProductTypeEnum::VARIABLE ? $this->skus->max( 'unit_amount' ) : $this->sku->unit_amount) ?? 0;
    }

    public function getSkusAttribute(): Collection
    {
        return $this->productAttributes->pluck( "skus" )->flatten();
    }

    public function sku(): HasOne
    {
        return $this->hasOne( Sku::class );
    }

    public function stock(): HasManyDeep
    {
        return $this->hasManyDeepFromRelations( $this->sku(), (new Sku())->stock() );
    }

    protected function scopeVariables(Builder $query): void
    {
        $query->where( 'type', ProductTypeEnum::VARIABLE );
    }

    protected function scopeSimple(Builder $query): void
    {
        $query->where( 'type', ProductTypeEnum::SIMPLE );
    }

    protected function scopePerishable(Builder $query): void
    {
        $query->where( 'type', ProductTypeEnum::PERISHABLE );
    }
}
