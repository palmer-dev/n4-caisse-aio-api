<?php

namespace App\Policies;

use App\Enums\PermissionsEnum;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can( PermissionsEnum::VIEW_USERS );
    }

    public function view(User $user, User $concernedUser): bool
    {
        return $user->can( PermissionsEnum::VIEW_USERS );
    }

    public function create(User $user): bool
    {
        return $user->can( PermissionsEnum::CREATE_USERS );
    }

    public function update(User $user, User $concernedUser): bool
    {
        return $user->can( PermissionsEnum::EDIT_USERS );
    }

    public function delete(User $user, User $concernedUser): bool
    {
        return $user->can( PermissionsEnum::DELETE_USERS );
    }

    public function restore(User $user, User $concernedUser): bool
    {
        return $user->can( PermissionsEnum::DELETE_USERS );
    }

    public function forceDelete(User $user, User $concernedUser): bool
    {
        return $user->can( PermissionsEnum::FORCE_DELETE_USERS );
    }
}
