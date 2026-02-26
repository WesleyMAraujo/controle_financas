<?php

namespace App\Filament\Resources\DividaResource\Pages;

use App\Filament\Resources\DividaResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDivida extends CreateRecord
{
    protected static string $resource = DividaResource::class;

    protected function preserveFormDataWhenCreatingAnother(): array
    {
        return [
            'data_inicio',
            'cartao_id',
            'pessoa_id',
        ];
    }
}
