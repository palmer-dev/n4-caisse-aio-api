<?php

namespace App\Policies;

use App\Enums\PermissionsEnum;
use App\Models\LoyaltyOffer;
use App\Models\User;
use App\Traits\ShopDependant;
use Illuminate\Auth\Access\HandlesAuthorization;

class LoyaltyOfferPolicy
{
    use HandlesAuthorization, ShopDependant;

    public function viewAny(User $user): bool
    {
        return $user->can( PermissionsEnum::VIEW_LOYALTY_OFFERS );
    }

    public function view(User $user, LoyaltyOffer $loyaltyOffer): bool
    {
        return $user->can( PermissionsEnum::VIEW_LOYALTY_OFFERS ) && $this->isInShop( $user, $loyaltyOffer );
    }

    public function create(User $user): bool
    {
        return $user->can( PermissionsEnum::CREATE_LOYALTY_OFFERS );
    }

    public function update(User $user, LoyaltyOffer $loyaltyOffer): bool
    {
        return $user->can( PermissionsEnum::EDIT_LOYALTY_OFFERS ) && $this->isInShop( $user, $loyaltyOffer );
    }

    public function delete(User $user, LoyaltyOffer $loyaltyOffer): bool
    {
        return $user->can( PermissionsEnum::DELETE_LOYALTY_OFFERS ) && $this->isInShop( $user, $loyaltyOffer );
    }

    public function restore(User $user, LoyaltyOffer $loyaltyOffer): bool
    {
        return $user->can( PermissionsEnum::DELETE_LOYALTY_OFFERS ) && $this->isInShop( $user, $loyaltyOffer );
    }

    public function forceDelete(User $user, LoyaltyOffer $loyaltyOffer): bool
    {
        return $user->can( PermissionsEnum::FORCE_DELETE_LOYALTY_OFFERS ) && $this->isInShop( $user, $loyaltyOffer );
    }
}
