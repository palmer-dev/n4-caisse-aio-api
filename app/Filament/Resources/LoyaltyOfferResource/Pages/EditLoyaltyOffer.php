<?php

namespace App\Filament\Resources\LoyaltyOfferResource\Pages;

use App\Filament\Resources\LoyaltyOfferResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditLoyaltyOffer extends EditRecord
{
	protected static string $resource = LoyaltyOfferResource::class;

	protected function getHeaderActions(): array
	{
		return [
			DeleteAction::make(),
			ForceDeleteAction::make(),
			RestoreAction::make(),
		];
	}
}
