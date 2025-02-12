<?php

namespace App\Policies;

use App\Enums\PermissionsEnum;
use App\Models\User;
use App\Models\VatRate;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can( PermissionsEnum::VIEW_USERS );
    }

    public function view(User $user, VatRate $vatRate): bool
    {
        return $user->can( PermissionsEnum::VIEW_USERS );
    }

    public function create(User $user): bool
    {
        return $user->can( PermissionsEnum::CREATE_USERS );
    }

    public function update(User $user, VatRate $vatRate): bool
    {
        return $user->can( PermissionsEnum::EDIT_USERS );
    }

    public function delete(User $user, VatRate $vatRate): bool
    {
        return $user->can( PermissionsEnum::DELETE_USERS );
    }

    public function restore(User $user, VatRate $vatRate): bool
    {
        return $user->can( PermissionsEnum::DELETE_USERS );
    }

    public function forceDelete(User $user, VatRate $vatRate): bool
    {
        return $user->can( PermissionsEnum::FORCE_DELETE_USERS );
    }
}
