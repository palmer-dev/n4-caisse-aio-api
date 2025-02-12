<?php

namespace App\Models;

use App\Models\Scopes\ByShop;
use App\Observers\CategoryObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy(CategoryObserver::class)]
#[ScopedBy(ByShop::class)]
class Category extends Model
{
    use HasUuids, HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'parent_id',
        'shop_id'
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo( Category::class, 'parent_id' );
    }

    public function shop(): BelongsTo
    {
        return $this->belongsTo( Shop::class );
    }

    public function children(): HasMany
    {
        return $this->hasMany( Category::class, 'parent_id' );
    }

    public function descendants()
    {
        return $this->children()->with( 'descendants' );
    }

    public function ascendants()
    {
        return $this->children()->with( 'ascendants' );
    }
}
