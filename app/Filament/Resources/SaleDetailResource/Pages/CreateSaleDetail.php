<?php

namespace App\Filament\Resources\SaleDetailResource\Pages;

use App\Filament\Resources\SaleDetailResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSaleDetail extends CreateRecord
{
	protected static string $resource = SaleDetailResource::class;

	protected function getHeaderActions(): array
	{
		return [

		];
	}
}
