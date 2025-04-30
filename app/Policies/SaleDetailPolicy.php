<?php

namespace App\Policies;

use App\Enums\PermissionsEnum;
use App\Models\SaleDetail;
use App\Models\User;
use App\Traits\ShopDependant;
use Illuminate\Auth\Access\HandlesAuthorization;

class SaleDetailPolicy
{
    use HandlesAuthorization;
    use ShopDependant;

    public function viewAny(User $user): bool
    {
        return $user->can( PermissionsEnum::VIEW_SALES );
    }

    public function view(User $user, SaleDetail $saleDetail): bool
    {
        return $user->can( PermissionsEnum::VIEW_SALES ) && $this->isInShop( $user, $saleDetail );
    }

    public function create(User $user): bool
    {
        return $user->can( PermissionsEnum::CREATE_SALES );
    }

    public function update(User $user, SaleDetail $saleDetail): bool
    {
        return $user->can( PermissionsEnum::EDIT_SALES ) && $this->isInShop( $user, $saleDetail );
    }

    public function delete(User $user, SaleDetail $saleDetail): bool
    {
        return $user->can( PermissionsEnum::DELETE_SALES ) && $this->isInShop( $user, $saleDetail );
    }

    public function restore(User $user, SaleDetail $saleDetail): bool
    {
        return $user->can( PermissionsEnum::DELETE_SALES ) && $this->isInShop( $user, $saleDetail );
    }

    public function forceDelete(User $user, SaleDetail $saleDetail): bool
    {
        return $user->can( PermissionsEnum::FORCE_DELETE_SALES ) && $this->isInShop( $user, $saleDetail );
    }
}
