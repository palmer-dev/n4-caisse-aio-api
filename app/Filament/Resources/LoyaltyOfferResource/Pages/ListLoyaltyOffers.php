<?php

namespace App\Filament\Resources\LoyaltyOfferResource\Pages;

use App\Filament\Resources\LoyaltyOfferResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLoyaltyOffers extends ListRecords
{
	protected static string $resource = LoyaltyOfferResource::class;

	protected function getHeaderActions(): array
	{
		return [
			CreateAction::make(),
		];
	}
}
