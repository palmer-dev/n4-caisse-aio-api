<?php

namespace App\Policies;

use App\Enums\PermissionsEnum;
use App\Models\Sku;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SkuPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can( PermissionsEnum::VIEW_SKUS );
    }

    public function view(User $user, Sku $sku): bool
    {
        return $user->can( PermissionsEnum::VIEW_SKUS );
    }

    public function create(User $user): bool
    {
        return $user->can( PermissionsEnum::CREATE_SKUS );
    }

    public function update(User $user, Sku $sku): bool
    {
        return $user->can( PermissionsEnum::EDIT_SKUS );
    }

    public function delete(User $user, Sku $sku): bool
    {
        return $user->can( PermissionsEnum::DELETE_SKUS );
    }

    public function restore(User $user, Sku $sku): bool
    {
        return $user->can( PermissionsEnum::DELETE_SKUS );
    }

    public function forceDelete(User $user, Sku $sku): bool
    {
        return $user->can( PermissionsEnum::FORCE_DELETE_SKUS );
    }
}
