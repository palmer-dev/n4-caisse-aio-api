<?php

namespace App\Filament\Resources\StockResource\Pages;

use App\Filament\Resources\StockResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditStock extends EditRecord
{
	protected static string $resource = StockResource::class;

	protected function getHeaderActions(): array
	{
		return [
			DeleteAction::make(),
			ForceDeleteAction::make(),
			RestoreAction::make(),
		];
	}
}
