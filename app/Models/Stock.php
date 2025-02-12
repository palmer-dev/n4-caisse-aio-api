<?php

namespace App\Models;

use App\Models\Scopes\ByShop;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Staudenmeir\EloquentHasManyDeep\HasOneDeep;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

#[ScopedBy(ByShop::class)]
class Stock extends Model
{
    use HasUuids, HasFactory, SoftDeletes, HasRelationships;

    protected $fillable = [
        'sku_id',
        'quantity',
    ];

    public function sku(): BelongsTo
    {
        return $this->belongsTo( Sku::class );
    }

    public function shop(): HasOneDeep
    {
        return $this->hasOneDeepFromRelations(
            $this->sku(),
            (new Sku())->product(),
            (new Product())->shop()
        );
    }

    public function movements(): HasManyThrough
    {
        return $this->hasManyThrough(
            StockMovements::class,
            Sku::class,
            'id',          // Clé primaire de Sku
            'sku_id',      // Clé étrangère de StockMovements
            'sku_id',      // Clé de relation sur Stock (clé étrangère sur Stock)
            'id'           // Clé primaire de Stock (référence à la clé primaire de Stock)
        );
    }

    public function product(): HasOneDeep
    {
        return $this->hasOneDeepFromRelations( $this->sku(), (new Sku())->product() );
    }

    public function productVariation(): HasOneDeep
    {
        return $this->hasOneDeepFromRelations( $this->sku(), (new Sku())->productAttributeSku() );
    }
}
