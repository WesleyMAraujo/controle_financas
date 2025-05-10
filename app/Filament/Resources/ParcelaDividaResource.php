<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ParcelaDividaResource\Pages;
use App\Filament\Resources\ParcelaDividaResource\RelationManagers;
use App\Models\ParcelaDivida;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Support\Collection;

class ParcelaDividaResource extends Resource
{
    protected static ?string $model = ParcelaDivida::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    // Alterar o nome que aparece no menu
    protected static ?string $label = 'Parcelas'; // Nome do recurso no menu

    // Caso prefira usar o método getLabel
    public static function getLabel(): string
    {
        return 'Parcelas'; // Nome do recurso no menu
    }

    public static function getPluralLabel(): string
    {
        return 'Tabela de Parcelas'; // Nome plural que pode ser usado em outros contextos
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('divida_id')
                    ->label('Dívida')
                    ->relationship('divida', 'nome') // Exibe o nome da dívida no select
                    ->required(),
                Forms\Components\Select::make('status_id')
                    ->label('Status')
                    ->relationship('status', 'nome') // Exibe o nome do status
                    ->required(),
                Forms\Components\TextInput::make('parcela')
                    ->label('Parcela (MM-AAAA)')
                    ->required()
                    ->maxLength(7), // Garante o formato MM-AAAA
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
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
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Filter::make('cartao_id')
                    ->label('Cartão')
                    ->form([
                        Forms\Components\Select::make('cartao_id')
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
                        Forms\Components\Select::make('status_id')
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
                            ->options(fn () => \App\Models\ParcelaDivida::query()
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
                            Forms\Components\Select::make('pessoa_id')
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
            ], layout: FiltersLayout::AboveContent)
            ->actions([
                Action::make('Pagar')
                    ->label('Pagar')
                    ->color('success')
                    ->icon('heroicon-o-check-circle')
                    ->requiresConfirmation()
                    ->action(function (ParcelaDivida $record) {
                        $record->status_id = 2; // Assume que 2 é o ID para "Pago"
                        $record->save();
                    }),
                Action::make('Reservar')
                    ->label('Reservar')
                    ->requiresConfirmation()
                    ->action(function (ParcelaDivida $record) {
                        $record->status_id = 3; // Assume que 3 é o ID para "Reservado"
                        $record->save();
                    }),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),

            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),

                BulkAction::make('pagar')
                    ->label('Pagar selecionadas')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(fn (Collection $records) => $records->each(function ($record) {
                        $record->update(['status_id' => 2]); // 2 = Pago
                    })),

                BulkAction::make('reservar')
                    ->label('Reservar selecionadas')
                    ->icon('heroicon-o-bookmark')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->action(fn (Collection $records) => $records->each(function ($record) {
                        $record->update(['status_id' => 3]); // 3 = Reservado
                    })),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListParcelaDividas::route('/'),
            'create' => Pages\CreateParcelaDivida::route('/create'),
            'edit' => Pages\EditParcelaDivida::route('/{record}/edit'),
        ];
    }
}
