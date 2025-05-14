<?php

namespace App\Models;

use App\Models\Scopes\ByShop;
use App\Observers\ClientObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ScopedBy(ByShop::class)]
#[ObservedBy(ClientObserver::class)]
class Client extends Model
{
    use HasUuids, HasFactory, SoftDeletes;

    protected $fillable = [
        'shop_id',
        'user_id',
        'firstname',
        'lastname',
        'zipcode',
        'email',
        'phone',
        'code',
        'newsletter',
        'birthdate',
    ];

    protected function casts(): array
    {
        return [
            'birthdate'  => 'date',
            'newsletter' => 'bool',
        ];
    }

    /**
     * Relations
     */
    public function shop(): BelongsTo
    {
        return $this->belongsTo( Shop::class );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo( User::class );
    }

    public function sales(): HasMany
    {
        return $this->hasMany( Sale::class );
    }
}
