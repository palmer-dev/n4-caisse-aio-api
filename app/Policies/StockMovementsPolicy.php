<?php

namespace App\Policies;

use App\Enums\PermissionsEnum;
use App\Models\StockMovements;
use App\Models\User;
use App\Traits\ShopDependant;
use Illuminate\Auth\Access\HandlesAuthorization;

class StockMovementsPolicy
{
    use HandlesAuthorization, ShopDependant;

    public function viewAny(User $user): bool
    {
        return $user->can( PermissionsEnum::VIEW_STOCK_MOVEMENTS );
    }

    public function view(User $user, StockMovements $stockMovements): bool
    {
        return $user->can( PermissionsEnum::VIEW_STOCK_MOVEMENTS ) && $this->isInShop( $user, $stockMovements );
    }

    public function create(User $user): bool
    {
        return $user->can( PermissionsEnum::VIEW_STOCK_MOVEMENTS );
    }

    public function update(User $user, StockMovements $stockMovements): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, StockMovements $stockMovements): bool
    {
        return $user->isAdmin();
    }

    public function restore(User $user, StockMovements $stockMovements): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, StockMovements $stockMovements): bool
    {
        return $user->isAdmin();
    }
}
