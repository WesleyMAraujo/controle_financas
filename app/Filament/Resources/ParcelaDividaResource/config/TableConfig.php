<?php

namespace App\Filament\Resources\ParcelaDividaResource\Config;

use Filament\Tables;
use Filament\Tables\Columns\Summarizers\Average;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\Summarizers\Range;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\Summarizers\Summarizer;
use Illuminate\Support\Collection;
use App\Models\ParcelaDivida;

class TableConfig
{
    public static function getColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('divida.nome')  //AQUI
                ->label('Dívida')
                ->sortable(),
            Tables\Columns\TextColumn::make('divida.cartao.nome')  //AQUI
                ->label('Cartão')
                ->badge()
                ->color(fn ($state) =>
                    $state === 'Inter' ? 'info' :
                    ($state === 'Nubank' ? 'success' :
                    ($state === 'Despesa' ? 'warning' : 'gray'))
                )
                ->sortable(),
            Tables\Columns\TextColumn::make('divida.pessoa.nome')  //AQUI
                ->label('Pessoa')
                ->sortable(),
            Tables\Columns\TextColumn::make('divida.valor_parcela')
                ->label('Valor Parcela')
                ->money('brl')
                ->summarize([
                    Sum::make(),
                ])
                ->sortable(),
            Tables\Columns\TextColumn::make('divida.parcelas_restantes')  //AQUI
                ->label('Parcelas Restantes')
                ->sortable(),
            Tables\Columns\TextColumn::make('status.nome') // Exibe o nome do status
                ->label('Status')
                ->badge()
                ->color(fn ($state) =>
                    $state === 'À Pagar' ? 'danger' :
                    ($state === 'Pago' ? 'success' :
                    ($state === 'Reservado' ? 'warning' : 'gray'))
                )
                ->sortable(),
            Tables\Columns\TextColumn::make('parcela')
                ->label('Parcela')
                ->sortable(),
        ];
    }
}
