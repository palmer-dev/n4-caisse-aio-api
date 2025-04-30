<?php

namespace App\Policies;

use App\Models\StockExpiration;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StockExpirationPolicy
{
	use HandlesAuthorization;

	public function viewAny(User $user): bool
	{

	}

	public function view(User $user, StockExpiration $stockExpiration): bool
	{
	}

	public function create(User $user): bool
	{
	}

	public function update(User $user, StockExpiration $stockExpiration): bool
	{
	}

	public function delete(User $user, StockExpiration $stockExpiration): bool
	{
	}

	public function restore(User $user, StockExpiration $stockExpiration): bool
	{
	}

	public function forceDelete(User $user, StockExpiration $stockExpiration): bool
	{
	}
}
