<?php

namespace App\Filament\Resources\StockResource\Pages;

use App\Enums\ProductTypeEnum;
use App\Filament\Resources\StockResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

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

    public function getTitle(): string|Htmlable
    {
        return __( "Edit stocks for" ) . " " . $this->getLabel();
    }

    private function getLabel(): string
    {
        if ($this->record->product->type === ProductTypeEnum::VARIABLE) {
            return $this->record->product->name . " / " . $this->record->productVariation->value;
        }

        return $this->record->product->name;
    }
}
