<?php

namespace App\Filament\Resources\SaleDetailResource\Pages;

use App\Filament\Resources\SaleDetailResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSaleDetails extends ListRecords
{
	protected static string $resource = SaleDetailResource::class;

	protected function getHeaderActions(): array
	{
		return [
			CreateAction::make(),
		];
	}
}
