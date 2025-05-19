<?php

namespace App\Filament\Resources\ParcelaDividaResource\Pages;

use App\Filament\Resources\ParcelaDividaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditParcelaDivida extends EditRecord
{
    protected static string $resource = ParcelaDividaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
