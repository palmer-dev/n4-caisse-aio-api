<?php

namespace App\Policies;

use App\Enums\PermissionsEnum;
use App\Models\ProductAttributeSku;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductAttributeSkuPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can( PermissionsEnum::VIEW_ATTRIBUTE_SKUS );
    }

    public function view(User $user, ProductAttributeSku $productAttributeSku): bool
    {
        return $user->can( PermissionsEnum::VIEW_ATTRIBUTE_SKUS );
    }

    public function create(User $user): bool
    {
        return $user->can( PermissionsEnum::CREATE_ATTRIBUTE_SKUS );

    }

    public function update(User $user, ProductAttributeSku $productAttributeSku): bool
    {
        return $user->can( PermissionsEnum::EDIT_ATTRIBUTE_SKUS );
    }

    public function delete(User $user, ProductAttributeSku $productAttributeSku): bool
    {
        return $user->can( PermissionsEnum::DELETE_ATTRIBUTE_SKUS );
    }

    public function restore(User $user, ProductAttributeSku $productAttributeSku): bool
    {
        return $user->can( PermissionsEnum::DELETE_ATTRIBUTE_SKUS );
    }

    public function forceDelete(User $user, ProductAttributeSku $productAttributeSku): bool
    {
        return $user->can( PermissionsEnum::FORCE_DELETE_ATTRIBUTE_SKUS );
    }
}
