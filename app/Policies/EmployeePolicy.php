<?php

namespace App\Policies;

use App\enums\PermissionsEnum;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmployeePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can( PermissionsEnum::VIEW_EMPLOYEES );
    }

    public function view(User $user, Employee $employee): bool
    {
        return $user->can( PermissionsEnum::VIEW_EMPLOYEES );
    }

    public function create(User $user): bool
    {
        return $user->can( PermissionsEnum::CREATE_EMPLOYEES );
    }

    public function update(User $user, Employee $employee): bool
    {
        return $user->can( PermissionsEnum::EDIT_EMPLOYEES );
    }

    public function delete(User $user, Employee $employee): bool
    {
        return $user->can( PermissionsEnum::DELETE_EMPLOYEES );
    }

    public function restore(User $user, Employee $employee): bool
    {
        return $user->can( PermissionsEnum::DELETE_EMPLOYEES );
    }

    public function forceDelete(User $user, Employee $employee): bool
    {
        return $user->can( PermissionsEnum::FORCE_DELETE_EMPLOYEES );
    }
}
