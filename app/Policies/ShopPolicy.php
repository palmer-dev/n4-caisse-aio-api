<?php

namespace App\Policies;

use App\Enums\PermissionsEnum;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShopPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can( PermissionsEnum::VIEW_SHOPS );
    }

    public function view(User $user, Shop $shop): bool
    {
        return $user->can( PermissionsEnum::VIEW_SHOPS );
    }

    public function create(User $user): bool
    {
        return $user->can( PermissionsEnum::CREATE_SHOPS );
    }

    public function update(User $user, Shop $shop): bool
    {
        return $user->can( PermissionsEnum::EDIT_SHOPS );
    }

    public function delete(User $user, Shop $shop): bool
    {
        return $user->can( PermissionsEnum::DELETE_SHOPS );
    }

    public function restore(User $user, Shop $shop): bool
    {
        return $user->can( PermissionsEnum::DELETE_SHOPS );
    }

    public function forceDelete(User $user, Shop $shop): bool
    {
        return $user->can( PermissionsEnum::FORCE_DELETE_SHOPS );
    }
}
