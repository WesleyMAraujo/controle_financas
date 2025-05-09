<?php

namespace App\Filament\Widgets;

use App\Models\Pessoa;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;

class TabelaResumoParcelas extends BaseWidget
{
    protected static ?string $heading = 'Resumo por Pessoa';

    protected function getTableQuery(): Builder
    {
        return Pessoa::query(); // Aqui você pode adicionar joins e selects personalizados
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('nome')->label('Nome'),
            Tables\Columns\TextColumn::make('divida.valor_total')->label('Valor Total'),
            Tables\Columns\TextColumn::make('divida.parcelas_restantes')->label('Parcelas Restantes'),
            // Você pode adicionar mais colunas aqui
        ];
    }
}
