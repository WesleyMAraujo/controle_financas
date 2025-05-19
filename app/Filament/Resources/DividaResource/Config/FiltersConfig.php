<?php

namespace App\Filament\Resources\DividaResource\Config;

use Filament\Tables\Filters\SelectFilter;
use App\Models\Divida;
use App\Models\Cartao;
use App\Models\Pessoa;

class FiltersConfig
{
    public static function getFilters(): array
    {
        return [
            SelectFilter::make('data_inicio')
                ->label('Data de Início')
                ->options(fn () => Divida::query()
                    ->select('data_inicio')
                    ->distinct()
                    ->orderBy('data_inicio', 'ASC')
                    ->pluck('data_inicio', 'data_inicio')
                ),

            // Filtro por cartao usando relacionamento
            SelectFilter::make('cartao_id')
                ->relationship('cartao', 'nome')
                ->label('Cartão')
                ->options(
                    Cartao::pluck('nome', 'id')
                )
                ->placeholder('Selecione um cartão'),

            SelectFilter::make('pessoa_id')
                ->relationship('pessoa', 'nome')
                ->label('Pessoa')
                ->options(
                    Pessoa::pluck('nome', 'id')
                )
                ->placeholder('Selecione uma pessoa')
        ];
    }
}
