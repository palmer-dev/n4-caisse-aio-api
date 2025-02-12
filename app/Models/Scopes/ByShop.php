<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * Automatically filter the models belonging to the shop
 */
class ByShop implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        $builder->when( auth()->check() && !auth()->user()->isAdmin(), function (Builder $builder) {
            $builder->whereRelation( "shop", "shops.id", auth()->user()->shop_id );
        } );
    }
}
