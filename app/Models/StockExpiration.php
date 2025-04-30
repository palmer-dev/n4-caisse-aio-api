<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockExpiration extends Model
{
    use HasUuids, HasFactory;

    protected $fillable = [
        'stock_movements_id',
        'expiration_date',
    ];

    public function stockMovements(): BelongsTo
    {
        return $this->belongsTo( StockMovements::class, 'stock_movements_id', 'id' );
    }

    protected function casts(): array
    {
        return [
            'expiration_date' => 'date',
        ];
    }
}
