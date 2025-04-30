<?php

namespace App\Models;

use App\Enums\MovementTypeEnum;
use App\Observers\StockMovementsObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Staudenmeir\EloquentHasManyDeep\HasOneDeep;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

#[ObservedBy(StockMovementsObserver::class)]
class StockMovements extends Model
{
    use HasUuids, HasFactory, SoftDeletes, HasRelationships;

    protected $fillable = [
        'sku_id',
        'quantity',
        'movement_type',
        'description',
    ];

    protected $casts = [
        "movement_type" => MovementTypeEnum::class,
    ];

    public function sku(): BelongsTo
    {
        return $this->belongsTo( Sku::class );
    }

    public function shop(): HasOneDeep
    {
        return $this->hasOneDeepFromRelations( $this->sku(), (new Sku())->product(), (new Product())->shop() );
    }

    public function stock(): HasOneDeep
    {
        return $this->hasOneDeepFromRelations( $this->sku(), (new Sku())->stock() );
    }

    public function product(): HasOneDeep
    {
        return $this->hasOneDeepFromRelations( $this->sku(), (new Sku())->product() );
    }

    public function stockExpiration(): HasMany
    {
        return $this->hasMany( StockExpiration::class, "stock_movements_id", "id" )
            ->orderBy( "expiration_date" );
    }
}
