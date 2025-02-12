<?php

namespace App\Policies;

use App\Enums\PermissionsEnum;
use App\Models\Product;
use App\Models\User;
use App\Traits\ShopDependant;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization, ShopDependant;

    public function viewAny(User $user): bool
    {
        return $user->can( PermissionsEnum::VIEW_PRODUCTS );
    }

    public function view(User $user, Product $product): bool
    {
        return $user->can( PermissionsEnum::VIEW_PRODUCTS ) && $this->isInShop( $user, $product );
    }

    public function create(User $user): bool
    {
        return $user->can( PermissionsEnum::CREATE_PRODUCTS );
    }

    public function update(User $user, Product $product): bool
    {
        return $user->can( PermissionsEnum::EDIT_PRODUCTS ) && $this->isInShop( $user, $product );
    }

    public function delete(User $user, Product $product): bool
    {
        return $user->can( PermissionsEnum::DELETE_PRODUCTS ) && $this->isInShop( $user, $product );
    }

    public function restore(User $user, Product $product): bool
    {
        return $user->can( PermissionsEnum::FORCE_DELETE_PRODUCTS ) && $this->isInShop( $user, $product );
    }

    public function forceDelete(User $user, Product $product): bool
    {
        return $user->can( PermissionsEnum::VIEW_PRODUCTS ) && $this->isInShop( $user, $product );
    }
}
