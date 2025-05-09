<?php

namespace App\Filament\Resources\CartaoResource\Pages;

use App\Filament\Resources\CartaoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCartao extends EditRecord
{
    protected static string $resource = CartaoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
