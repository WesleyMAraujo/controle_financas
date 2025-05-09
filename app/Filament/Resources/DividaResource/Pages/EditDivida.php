<?php

namespace App\Filament\Resources\DividaResource\Pages;

use App\Filament\Resources\DividaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDivida extends EditRecord
{
    protected static string $resource = DividaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
