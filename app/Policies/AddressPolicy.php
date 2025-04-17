<?php

namespace App\Policies;

use App\Enums\PermissionsEnum;
use App\Models\Address;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AddressPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can( PermissionsEnum::VIEW_SHOPS );
    }

    public function view(User $user, Address $address): bool
    {
        return $user->can( PermissionsEnum::VIEW_SHOPS );
    }

    public function create(User $user): bool
    {
        return $user->can( PermissionsEnum::CREATE_SHOPS );
    }

    public function update(User $user, Address $address): bool
    {
        return $user->can( PermissionsEnum::EDIT_SHOPS );
    }

    public function delete(User $user, Address $address): bool
    {
        return $user->can( PermissionsEnum::DELETE_SHOPS );
    }

    public function restore(User $user, Address $address): bool
    {
        return $user->can( PermissionsEnum::DELETE_SHOPS );
    }

    public function forceDelete(User $user, Address $address): bool
    {
        return $user->can( PermissionsEnum::FORCE_DELETE_SHOPS );
    }
}
