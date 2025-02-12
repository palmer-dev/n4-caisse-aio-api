<?php

namespace App\Policies;

use App\Enums\PermissionsEnum;
use App\Models\User;
use App\Models\VatRate;
use Illuminate\Auth\Access\HandlesAuthorization;

class VatRatePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can( PermissionsEnum::VIEW_VAT_RATES );
    }

    public function view(User $user, VatRate $vatRate): bool
    {
        return $user->can( PermissionsEnum::VIEW_VAT_RATES );
    }

    public function create(User $user): bool
    {
        return $user->can( PermissionsEnum::CREATE_VAT_RATES );
    }

    public function update(User $user, VatRate $vatRate): bool
    {
        return $user->can( PermissionsEnum::EDIT_VAT_RATES );
    }

    public function delete(User $user, VatRate $vatRate): bool
    {
        return $user->can( PermissionsEnum::DELETE_VAT_RATES );
    }

    public function restore(User $user, VatRate $vatRate): bool
    {
        return $user->can( PermissionsEnum::DELETE_VAT_RATES );
    }

    public function forceDelete(User $user, VatRate $vatRate): bool
    {
        return $user->can( PermissionsEnum::FORCE_DELETE_VAT_RATES );
    }
}
