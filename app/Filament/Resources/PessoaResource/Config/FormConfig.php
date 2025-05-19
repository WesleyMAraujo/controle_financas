<?php
namespace App\Filament\Resources\PessoaResource\Config;

use Filament\Forms;
use Filament\Forms\Components\Section; // Importar Section
use Filament\Forms\Components\Grid;    // Importar Grid
use Filament\Forms\Components\TextInput; // Importar explicitamente se preferir
use Filament\Forms\Components\Select;   // Importar explicitamente se preferir
use Filament\Forms\Components\DatePicker;

class FormConfig
{
    public static function schema(): array
    {
        return [
            // Seção 1: Informações Básicas da Dívida
            Section::make('Informações da Pessoa')
                ->schema([
                    TextInput::make('nome')
                        ->label('Nome')
                        ->required()
                        ->maxLength(255),

                    Grid::make(2) // Grid com 2 colunas para os campos abaixo
                        ->schema([
                            TextInput::make('salario')
                                ->label('Salario')
                                ->required()
                                ->numeric()
                                ->step(0.01)
                                ->prefix('R$'),
                        ]),
                ]),

        ];
    }
}
