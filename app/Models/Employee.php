<?php

namespace App\Models;

use App\Models\Scopes\ByShop;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ScopedBy(ByShop::class)]
class Employee extends Model
{
    use HasUuids, HasFactory, SoftDeletes;

    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'phone',
        'code',
        'shop_id',
    ];

    public function shop(): BelongsTo
    {
        return $this->belongsTo( Shop::class );
    }
}
