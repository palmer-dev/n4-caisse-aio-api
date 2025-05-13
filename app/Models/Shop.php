<?php

namespace App\Models;

use App\Enums\RolesEnum;
use App\Traits\HasAddresses;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shop extends Model
{
    use HasUuids, HasFactory, SoftDeletes, HasAddresses;

    protected $fillable = [
        'name',
    ];

    public function managers(): HasMany
    {
        return $this->hasMany( User::class )
            ->whereHas( 'roles', function ($query) {
                $query->where( 'name', RolesEnum::MANAGER ); // Remplace 'name' par le nom de la colonne qui contient le rôle dans la table roles
            } );
    }

    public function employees(): HasMany
    {
        return $this->hasMany( Employee::class );
    }

    public function loyaltyOffers(): HasMany
    {
        return $this->hasMany( LoyaltyOffer::class );
    }

    public function clients(): HasMany
    {
        return $this->hasMany( Client::class );
    }

    public function sales(): HasMany
    {
        return $this->hasMany( Sale::class );
    }
}
