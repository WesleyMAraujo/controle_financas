<?php
namespace App\Filament\Resources\DividaResource\Config;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
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
                        ->label('Nome')
                        ->required()
                        ->maxLength(255),

                    Grid::make(3) // Grid com 2 colunas para os campos abaixo
                        ->schema([
                            TextInput::make('valor_parcela')
                                ->label('Valor da Parcela')
                                ->required()
                                ->numeric()
                                ->step(0.01)
                                ->prefix('R$'), // Adicionando prefixo de moeda
                            TextInput::make('parcelas_restantes')
                                ->label('Parcelas Restantes')
                                ->required()
                                ->integer()
                                ->minValue(1),
                            TextInput::make('data_inicio')
                                ->label('Data Início (MM/AAAA)')
                                ->placeholder('MM/AAAA')
                                ->maxLength(7)
                                 ->required()
                                ->default(now()->format('m-Y')),
                        ]),

                    Grid::make(2)
                        ->schema([
                        Select::make('cartao_id')
                            ->label('Cartão')
                            ->relationship('cartao', 'nome')
                            ->nullable(),
                        Select::make('pessoa_id')
                            ->label('Pessoa')
                            ->relationship('pessoa', 'nome')
                            ->required()
                            ->default(1),
                        ]),
                ]),
        ];
    }
}
