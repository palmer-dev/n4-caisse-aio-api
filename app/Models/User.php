<?php

namespace App\Models;

use App\Enums\RolesEnum;
use App\Models\Scopes\ByShop;
use Database\Factories\UserFactory;
use DateTimeInterface;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\NewAccessToken;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail, FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasUuids, HasRoles, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'phone',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    public function getNameAttribute(): string
    {
        return "{$this->lastname} {$this->firstname}";
    }

    public function shop(): BelongsTo
    {
        return $this->belongsTo( Shop::class );
    }

    /**
     * Return the shops where the user has a client fidelity history
     * @return HasMany
     */
    public function clients(): HasMany
    {
        return $this->hasMany( Client::class )
            ->withoutGlobalScope( ByShop::class );
    }

    public function clientShops(): HasManyThrough
    {
        return $this->hasManyThrough(
            Shop::class,     // Le modèle final (Shop)
            Client::class,   // Le modèle intermédiaire (Client)
            'user_id',       // Clé étrangère sur la table Client qui pointe vers User
            'id',            // Clé primaire sur la table Shop
            'id',            // Clé primaire sur la table User
            'shop_id'        // Clé étrangère sur la table Client qui pointe vers Shop
        );
    }

    public function saveToken(string $name, string $token, array $abilities = ['*'], ?DateTimeInterface $expiresAt = null): NewAccessToken
    {
        $token = $this->tokens()->create( [
            'name'       => $name,
            'token'      => hash( 'sha256', $token ),
            'abilities'  => $abilities,
            'expires_at' => $expiresAt,
        ] );

        return new NewAccessToken( $token, $token->getKey() . '|' . $token );
    }

    public function isAdmin(): bool
    {
        return $this->hasRole( RolesEnum::ADMIN );
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasVerifiedEmail();
    }
}
