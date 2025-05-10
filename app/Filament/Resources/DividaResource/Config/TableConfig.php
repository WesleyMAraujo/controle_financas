<?php

namespace App\Filament\Resources\DividaResource\Config;

use Filament\Tables;

class TableConfig
{
    public static function getColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('nome')
                ->label('Nome')
                ->sortable(),
            Tables\Columns\TextColumn::make('cartao.nome') // Exibe o nome do cartão
                ->label('Cartão')
                ->sortable(),
            Tables\Columns\TextColumn::make('pessoa.nome')
                ->label('Pessoa')
                ->sortable(),
            Tables\Columns\TextColumn::make('valor_parcela')
                ->label('Valor Parcela')
                ->money('brl')
                ->sortable(),
            Tables\Columns\TextColumn::make('valor_total')
                ->label('Total')
                ->money('brl')
                ->sortable(),
            Tables\Columns\TextColumn::make('parcelas_restantes')
                ->label('Parcelas')
                ->sortable(),
            Tables\Columns\TextColumn::make('data_inicio')
                ->label('Data Início')
                ->sortable(),
            Tables\Columns\TextColumn::make('created_at')
                ->label('Criado em')
                ->dateTime()
                ->sortable(),
        ];
    }
}
