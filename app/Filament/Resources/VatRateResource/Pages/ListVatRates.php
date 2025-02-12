<?php

namespace App\Filament\Resources\VatRateResource\Pages;

use App\Filament\Resources\VatRateResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListVatRates extends ListRecords
{
	protected static string $resource = VatRateResource::class;

	protected function getHeaderActions(): array
	{
		return [
			CreateAction::make(),
		];
	}
}
