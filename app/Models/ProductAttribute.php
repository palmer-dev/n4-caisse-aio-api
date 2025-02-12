<?php

namespace App\Models;

use App\Models\Scopes\ByShop;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Staudenmeir\EloquentHasManyDeep\HasOneDeep;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class ProductAttribute extends Model
{
    use HasUuids, HasFactory, SoftDeletes, HasRelationships;

    protected $fillable = [
        'product_id',
        'name',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo( Product::class );
    }

    public function productAttributeSkus(): HasMany
    {
        return $this->hasMany( ProductAttributeSku::class );
    }

    public function skus(): HasManyThrough
    {
        return $this->hasManyThrough( Sku::class, ProductAttributeSku::class, 'product_attribute_id', 'product_attribute_sku_id', 'id', 'id' );
    }
}
