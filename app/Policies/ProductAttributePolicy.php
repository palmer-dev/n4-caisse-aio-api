<?php

namespace App\Policies;

use App\Enums\PermissionsEnum;
use App\Models\ProductAttribute;
use App\Models\User;
use App\Traits\ShopDependant;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;

class ProductAttributePolicy
{
    use HandlesAuthorization, ShopDependant;

    public function viewAny(User $user): bool
    {
        return $user->can( PermissionsEnum::VIEW_PRODUCT_ATTRIBUTES );
    }

    public function view(User $user, ProductAttribute $productAttribute): bool
    {
        return $user->can( PermissionsEnum::VIEW_PRODUCT_ATTRIBUTES ) && $this->isInShop( $user, $productAttribute );
    }

    public function create(User $user): bool
    {
        return $user->can( PermissionsEnum::CREATE_PRODUCT_ATTRIBUTES );
    }

    public function update(User $user, ProductAttribute $productAttribute): bool
    {
        return $user->can( PermissionsEnum::EDIT_PRODUCT_ATTRIBUTES ) && $this->isInShop( $user, $productAttribute );
    }

    public function delete(User $user, ProductAttribute $productAttribute): bool
    {
        return $user->can( PermissionsEnum::DELETE_PRODUCT_ATTRIBUTES ) && $this->isInShop( $user, $productAttribute );
    }

    public function restore(User $user, ProductAttribute $productAttribute): bool
    {
        return $user->can( PermissionsEnum::DELETE_PRODUCT_ATTRIBUTES ) && $this->isInShop( $user, $productAttribute );
    }

    public function forceDelete(User $user, ProductAttribute $productAttribute): bool
    {
        return $user->can( PermissionsEnum::FORCE_DELETE_PRODUCT_ATTRIBUTES ) && $this->isInShop( $user, $productAttribute );
    }
}
