<?php

namespace App\Filament\Resources\DividaResource\Pages;

use App\Filament\Resources\DividaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDividas extends ListRecords
{
    protected static string $resource = DividaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
