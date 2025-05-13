<?php

namespace App\Models;

use App\Casts\MoneyCast;
use App\Enums\DiscountType;
use App\Models\Scopes\ByShop;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[ScopedBy(ByShop::class)]
class Discount extends Model
{
    use HasUuids, HasFactory;

    protected $fillable = [
        'name',
        'type',
        'value',
        'start_date',
        'end_date',
        'is_active',
        'shop_id',
    ];

    protected function casts(): array
    {
        return [
            'type'       => DiscountType::class,
            'start_date' => 'datetime',
            'end_date'   => 'datetime',
            'is_active'  => 'boolean',
            'value'      => MoneyCast::class
        ];
    }

    public function skus(): BelongsToMany
    {
        return $this->belongsToMany( Sku::class );
    }

    public function shop(): BelongsTo
    {
        return $this->belongsTo( Shop::class );
    }

    public function scopeCurrent(Builder $query): void
    {
        $query->where( 'is_active', true )
            ->whereDate( 'start_date', '<=', now() )
            ->whereDate( 'end_date', '>=', now() );
    }
}
