<?php
namespace App\Filament\Resources\DividaResource\Config;

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
            Section::make('Informações da Dívida')
                ->description('Detalhes principais da dívida e parcelamento.')
                ->schema([
                    TextInput::make('nome')
                        ->label('Nome')
                        ->required()
                        ->maxLength(255),

                    Grid::make(2) // Grid com 2 colunas para os campos abaixo
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
                                ->minValue(1), // Use minValue() em vez de rule('min:1') para validação Filament
                        ]),

                    // Assumindo que 'data_inicio' deve ser um DatePicker ou Text Input formatado
                     TextInput::make('data_inicio') // Ou DatePicker::make('data_inicio')->format('m/Y')
                        ->label('Data Início (MM/AAAA)')
                        ->placeholder('MM/AAAA')
                        ->maxLength(7)
                         ->required() // Provavelmente deve ser obrigatório
                        ->default(now()->format('m-Y')), // Default é 'm-Y', talvez precise ajustar para 'm/Y' ou usar DatePicker
                        // Validação customizada para MM/AAAA, se não usar DatePicker
                       // ->regex('/^(0[1-9]|1[0-2])\/\d{4}$/', 'O formato deve ser MM/AAAA'),

                ]),

            // Seção 2: Relacionamentos
            Section::make('Relacionamentos')
                 ->description('Associe a dívida a um cartão e pessoa.')
                 ->schema([
                    Grid::make(2) // Grid com 2 colunas para os selects
                        ->schema([
                            Select::make('cartao_id')
                                ->label('Cartão')
                                ->relationship('cartao', 'nome')
                                ->nullable(), // Ou required(), dependendo da sua regra de negócio
                            Select::make('pessoa_id')
                                ->label('Pessoa')
                                ->relationship('pessoa', 'nome')
                                ->required() // Geralmente uma dívida pertence a alguém
                                ->default(1), // Verifique se o default=1 faz sentido no seu contexto
                        ]),
                 ]),

            // Você pode adicionar outras seções ou grids conforme necessário
        ];
    }
}
