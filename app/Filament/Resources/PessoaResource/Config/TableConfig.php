<?php

namespace App\Filament\Resources\PessoaResource\Config;

use Filament\Tables;

class TableConfig
{
    public static function getColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('id')
                ->label('ID')
                ->sortable(),
            Tables\Columns\TextColumn::make('nome')
                ->label('Nome')
                ->searchable(),
            Tables\Columns\TextColumn::make('salario')
                ->label('Salario')
                ->money('brl')
                ->sortable(),
            Tables\Columns\TextColumn::make('created_at')
                ->label('Criado em')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
