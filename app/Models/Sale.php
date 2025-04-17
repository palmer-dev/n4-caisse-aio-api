<?php

namespace App\Models;

use App\Casts\MoneyCast;
use App\Models\Scopes\ByShop;
use App\Observers\SaleUniqueNumber;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy(SaleUniqueNumber::class)]
#[ScopedBy(ByShop::class)]
class Sale extends Model
{
    use HasUuids, HasFactory, SoftDeletes;

    protected $fillable = [
        'shop_id',
        'sale_no',
        'employee_id',
        'client_id',
        'discount',
        'sub_total',
        'grand_total',
    ];

    protected $casts = [
        "sub_total"   => MoneyCast::class,
        "grand_total" => MoneyCast::class,
    ];

    public function shop(): BelongsTo
    {
        return $this->belongsTo( Shop::class );
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo( Employee::class );
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo( Client::class );
    }

    public function details(): HasMany
    {
        return $this->hasMany( SaleDetail::class );
    }
}
