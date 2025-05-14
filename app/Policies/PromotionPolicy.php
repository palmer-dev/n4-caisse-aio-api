<?php

namespace App\Policies;

use App\Enums\PermissionsEnum;
use App\Models\Discount;
use App\Models\User;
use App\Traits\ShopDependant;
use Illuminate\Auth\Access\HandlesAuthorization;

class PromotionPolicy
{
    use HandlesAuthorization, ShopDependant;

    public function viewAny(User $user): bool
    {
        return $user->can( PermissionsEnum::VIEW_LOYALTY_OFFERS );
    }

    public function view(User $user, Discount $promotion): bool
    {
        return $user->can( PermissionsEnum::VIEW_LOYALTY_OFFERS ) && $this->isInShop( $user, $promotion );
    }

    public function create(User $user): bool
    {
        return $user->can( PermissionsEnum::CREATE_LOYALTY_OFFERS );
    }

    public function update(User $user, Discount $promotion): bool
    {
        return $user->can( PermissionsEnum::EDIT_LOYALTY_OFFERS ) && $this->isInShop( $user, $promotion );
    }

    public function delete(User $user, Discount $promotion): bool
    {
        return $user->can( PermissionsEnum::DELETE_LOYALTY_OFFERS ) && $this->isInShop( $user, $promotion );
    }

    public function restore(User $user, Discount $promotion): bool
    {
        return $user->can( PermissionsEnum::FORCE_DELETE_LOYALTY_OFFERS ) && $this->isInShop( $user, $promotion );
    }

    public function forceDelete(User $user, Discount $promotion): bool
    {
        return $user->can( PermissionsEnum::FORCE_DELETE_LOYALTY_OFFERS ) && $this->isInShop( $user, $promotion );
    }
}
