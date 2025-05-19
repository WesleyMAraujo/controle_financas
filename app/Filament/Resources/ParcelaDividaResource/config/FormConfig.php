<?php

namespace App\Filament\Resources\ParcelaDividaResource\Config;

use Filament\Forms;
use Filament\Forms\Components\Section;

class FormConfig
{
    public static function schema(): array
    {
        return [
            // Seção 1: Informações Básicas da Dívida
            Section::make('Informações da Parcela')
                ->schema([
                    Forms\Components\Select::make('divida_id')
                        ->label('Dívida')
                        ->relationship('divida', 'nome') // Exibe o nome da dívida no select
                        ->required(),
                    Forms\Components\Select::make('status_id')
                        ->label('Status')
                        ->relationship('status', 'nome') // Exibe o nome do status
                        ->required(),
                    Forms\Components\TextInput::make('parcela')
                        ->label('Parcela (MM-AAAA)')
                        ->required()
                        ->maxLength(7),

                ]),
        ];
    }
}
