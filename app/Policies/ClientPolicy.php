<?php

namespace App\Policies;

use App\Enums\PermissionsEnum;
use App\Models\Client;
use App\Models\User;
use App\Traits\ShopDependant;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientPolicy
{
    use HandlesAuthorization, ShopDependant;

    public function viewAny(User $user): bool
    {
        return $user->can( PermissionsEnum::VIEW_CLIENTS );
    }

    public function view(User $user, Client $client): bool
    {
        return $user->can( PermissionsEnum::VIEW_CLIENTS );
    }

    public function create(User $user): bool
    {
        return $user->can( PermissionsEnum::CREATE_CLIENTS );
    }

    public function update(User $user, Client $client): bool
    {
        return $user->can( PermissionsEnum::EDIT_CLIENTS ) && $this->isInShop( $user, $client );
    }

    public function delete(User $user, Client $client): bool
    {
        return $user->can( PermissionsEnum::DELETE_CLIENTS ) && $this->isInShop( $user, $client );
    }

    public function restore(User $user, Client $client): bool
    {
        return $user->can( PermissionsEnum::DELETE_CLIENTS ) && $this->isInShop( $user, $client );
    }

    public function forceDelete(User $user, Client $client): bool
    {
        return $user->can( PermissionsEnum::FORCE_DELETE_CLIENTS ) && $this->isInShop( $user, $client );
    }
}
