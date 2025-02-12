<?php

namespace App\Policies;

use App\Enums\PermissionsEnum;
use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can( PermissionsEnum::VIEW_CATEGORIES );
    }

    public function view(User $user, Category $category): bool
    {
        return $user->can( PermissionsEnum::VIEW_CATEGORIES );
    }

    public function create(User $user): bool
    {
        return $user->can( PermissionsEnum::CREATE_CATEGORIES );
    }

    public function update(User $user, Category $category): bool
    {
        return $user->can( PermissionsEnum::EDIT_CATEGORIES );
    }

    public function delete(User $user, Category $category): bool
    {
        return $user->can( PermissionsEnum::DELETE_CATEGORIES );
    }

    public function restore(User $user, Category $category): bool
    {
        return $user->can( PermissionsEnum::DELETE_CATEGORIES );
    }

    public function forceDelete(User $user, Category $category): bool
    {
        return $user->can( PermissionsEnum::FORCE_DELETE_CATEGORIES );
    }
}
