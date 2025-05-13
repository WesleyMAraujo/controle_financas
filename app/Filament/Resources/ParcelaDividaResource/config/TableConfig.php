<?php

namespace App\Filament\Resources\ParcelaDividaResource\Config;

use Filament\Tables;

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
