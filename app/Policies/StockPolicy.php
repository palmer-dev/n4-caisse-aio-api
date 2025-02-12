<?php

namespace App\Policies;

use App\Enums\PermissionsEnum;
use App\Models\Stock;
use App\Models\User;
use App\Traits\ShopDependant;
use Illuminate\Auth\Access\HandlesAuthorization;

class StockPolicy
{
    use HandlesAuthorization, ShopDependant;

    public function viewAny(User $user): bool
    {
        return $user->can( PermissionsEnum::VIEW_STOCKS );
    }

    public function view(User $user, Stock $stock): bool
    {
        return $user->can( PermissionsEnum::VIEW_STOCKS ) && $this->isInShop( $user, $stock->sku->getRelatedProductAttribute() );
    }

    public function create(User $user): bool
    {
        return $user->can( PermissionsEnum::CREATE_STOCKS );
    }

    public function update(User $user, Stock $stock): bool
    {
        return $user->can( PermissionsEnum::EDIT_STOCKS ) && $this->isInShop( $user, $stock->sku->product );
    }

    public function delete(User $user, Stock $stock): bool
    {
        return $user->can( PermissionsEnum::DELETE_STOCKS ) && $this->isInShop( $user, $stock->sku->product );
    }

    public function restore(User $user, Stock $stock): bool
    {
        return $user->can( PermissionsEnum::DELETE_STOCKS ) && $this->isInShop( $user, $stock->sku->product );
    }

    public function forceDelete(User $user, Stock $stock): bool
    {
        return $user->can( PermissionsEnum::FORCE_DELETE_STOCKS ) && $this->isInShop( $user, $stock->sku->product );
    }
}
