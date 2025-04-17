<?php

namespace App\Filament\Resources\SaleDetailResource\Pages;

use App\Filament\Resources\SaleDetailResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSaleDetail extends EditRecord
{
	protected static string $resource = SaleDetailResource::class;

	protected function getHeaderActions(): array
	{
		return [
			DeleteAction::make(),
		];
	}
}
