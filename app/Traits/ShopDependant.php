<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

trait ShopDependant
{
    //
    public function isInShop(User $user, Model $model): bool
    {
        return (!$this->needShopScope( $user )) || ($model->shop_id ?? $model->shop->id) === $user->shop_id;
    }

    private function needShopScope(User $user): bool
    {
        return !$user->isAdmin();
    }
}
