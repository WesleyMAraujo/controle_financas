<?php

namespace App\Filament\Resources\CartaoResource\Config;

use Filament\Tables\Columns\TextColumn;

class TableConfig
{
    public static function getColumns(): array
    {
        return [
            TextColumn::make('id') // Adiciona a coluna 'id'
                ->label('ID')
                ->sortable(),
            TextColumn::make('nome')
                ->label('Nome') // Rótulo da coluna
                ->searchable(),
            TextColumn::make('limite')
                ->label('Limite')
                ->money('brl')
                ->searchable(),
            TextColumn::make('dia_vencimento')
                ->label('Dia de Vencimento') // Rótulo da coluna
                ->searchable(),
        ];
    }
}
