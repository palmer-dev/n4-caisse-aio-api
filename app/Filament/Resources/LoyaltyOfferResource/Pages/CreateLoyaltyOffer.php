<?php

namespace App\Filament\Resources\LoyaltyOfferResource\Pages;

use App\Filament\Resources\LoyaltyOfferResource;
use Filament\Resources\Pages\CreateRecord;

class CreateLoyaltyOffer extends CreateRecord
{
	protected static string $resource = LoyaltyOfferResource::class;

	protected function getHeaderActions(): array
	{
		return [

		];
	}
}
