<?php

namespace App\Filament\Resources\ParcelaDividaResource\Pages;

use App\Filament\Resources\ParcelaDividaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListParcelaDividas extends ListRecords
{
    protected static string $resource = ParcelaDividaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
