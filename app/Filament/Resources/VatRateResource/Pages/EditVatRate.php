<?php

namespace App\Filament\Resources\VatRateResource\Pages;

use App\Filament\Resources\VatRateResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditVatRate extends EditRecord
{
	protected static string $resource = VatRateResource::class;

	protected function getHeaderActions(): array
	{
		return [
			DeleteAction::make(),
			ForceDeleteAction::make(),
			RestoreAction::make(),
		];
	}
}
