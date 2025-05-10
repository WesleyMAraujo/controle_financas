<?php

namespace App\Filament\Resources\ParcelaDividaResource\Config;

use App\Models\ParcelaDivida;
use Filament\Forms\Components\Select;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class FiltersConfig
{
    public static function getFilters(): array
    {
        return [
            Filter::make('cartao_id')
            ->label('Cartão')
            ->form([
                Select::make('cartao_id')
                    ->label('Cartão')
                    ->relationship('divida.cartao', 'nome') // Use o relacionamento correto
                    ->searchable()
                    ->preload(),
            ])
            ->query(function (Builder $query, array $data): Builder {
                return $query->when($data['cartao_id'], function ($q) use ($data) {
                    $q->whereHas('divida', function ($q) use ($data) {
                        $q->where('cartao_id', $data['cartao_id']);
                    });
                });
            }),


        Filter::make('status_id')
            ->label('Status')
            ->form([
                Select::make('status_id')
                    ->label('Status')
                    ->relationship('status', 'nome')
                    ->searchable()
                    ->preload(),
            ])
            ->query(function (Builder $query, array $data): Builder {
                return $query->when($data['status_id'], fn ($q) => $q->where('status_id', $data['status_id']));
            }),
        Filter::make('parcela')
            ->form([
                Select::make('parcela')
                    ->label('Mês')
                    ->options(fn () => ParcelaDivida::query()
                    ->orderByRaw('STR_TO_DATE(parcela, "%m-%Y") DESC') // Ordena pela data de forma decrescente


                        ->select('parcela')
                        ->distinct()
                        ->pluck('parcela', 'parcela'))
                    ->searchable()
                    ->placeholder('Mês'),
            ])
            ->query(function (Builder $query, array $data) {
                if (!empty($data['parcela'])) {
                    return $query->where('parcela', $data['parcela']);
                }

                $firstParcela = ParcelaDivida::query()
                    ->orderByRaw('STR_TO_DATE(parcela, "%m-%Y") DESC') // Ordena pela data de forma decrescente

                    ->first();
                if(isset($firstParcela->parcela))
                {
                    return $query->where('parcela', $firstParcela->parcela);
                }
                // Caso contrário, retorna as parcelas para o mês atual
            }),

            Filter::make('pessoa_id')
                ->label('Pessoa')
                ->form([
                    Select::make('pessoa_id')
                        ->label('Pessoa')
                        ->relationship('divida.pessoa', 'nome') // Use o relacionamento correto
                        ->searchable()
                        ->preload(),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query->when($data['pessoa_id'], function ($q) use ($data) {
                        $q->whereHas('divida', function ($q) use ($data) {
                            $q->where('pessoa_id', $data['pessoa_id']);
                        });
                    });
                }),
        ];
    }
}
