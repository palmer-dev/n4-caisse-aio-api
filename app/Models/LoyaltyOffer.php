<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoyaltyOffer extends Model
{
    use HasUuids, HasFactory, SoftDeletes;

    protected $fillable = [
        'points',
        'start_date',
        'end_date',
        'is_active',
        'shop_id',
    ];

    public function shop(): BelongsTo
    {
        return $this->belongsTo( Shop::class );
    }

    protected function casts(): array
    {
        return [
            'start_date' => 'timestamp',
            'end_date'   => 'timestamp',
            'is_active'  => 'boolean',
        ];
    }
}
