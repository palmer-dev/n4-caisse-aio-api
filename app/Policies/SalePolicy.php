<?php

namespace App\Policies;

use App\Enums\PermissionsEnum;
use App\Models\Sale;
use App\Models\User;
use App\Traits\ShopDependant;
use Illuminate\Auth\Access\HandlesAuthorization;

class SalePolicy
{
    use HandlesAuthorization;
    use ShopDependant;

    public function viewAny(User $user): bool
    {
        return $user->can( PermissionsEnum::VIEW_SALES );
    }

    public function view(User $user, Sale $sale): bool
    {
        return $user->can( PermissionsEnum::VIEW_SALES ) && $this->isInShop( $user, $sale );
    }

    public function create(User $user): bool
    {
        return $user->can( PermissionsEnum::CREATE_SALES );
    }

    public function update(User $user, Sale $sale): bool
    {
        return $user->can( PermissionsEnum::EDIT_SALES ) && $this->isInShop( $user, $sale );
    }

    public function delete(User $user, Sale $sale): bool
    {
        return $user->can( PermissionsEnum::DELETE_SALES ) && $this->isInShop( $user, $sale );
    }

    public function restore(User $user, Sale $sale): bool
    {
        return $user->can( PermissionsEnum::DELETE_SALES ) && $this->isInShop( $user, $sale );
    }

    public function forceDelete(User $user, Sale $sale): bool
    {
        return $user->can( PermissionsEnum::FORCE_DELETE_SALES ) && $this->isInShop( $user, $sale );
    }
}
