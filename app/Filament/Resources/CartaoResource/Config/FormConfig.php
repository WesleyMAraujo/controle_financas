<?php

namespace App\Filament\Resources\CartaoResource\Config;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;

class FormConfig
{
    public static function schema(): array
    {
        return [
            // Seção 1: Informações Básicas da Dívida
            Section::make('Informações da Dívida')
                ->schema([
                    TextInput::make('nome')
                        ->label('Nome') // Rótulo do campo
                        ->required()
                        ->maxLength(255),

                    Grid::make(2)
                        ->schema([
                            TextInput::make('limite')
                                ->label('Limite')
                                ->numeric()
                                ->step(0.01)
                                ->prefix('R$')
                                ->minValue(0),

                            TextInput::make('dia_vencimento')
                                ->label('Dia de Vencimento')
                                ->integer()
                                ->rule('min:1')
                                ->rule('max:31'),
                        ]),
                ]),


        ];
    }
}
