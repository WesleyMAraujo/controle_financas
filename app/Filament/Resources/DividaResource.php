<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DividaResource\Pages;
use App\Filament\Resources\DividaResource\RelationManagers;
use App\Models\Divida;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Select;
use App\Models\Cartao;
use App\Models\Pessoa;

class DividaResource extends Resource
{
    protected static ?string $model = Divida::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nome')
                    ->label('Nome')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('valor_parcela')
                    ->label('Valor da Parcela')
                    ->required()
                    ->numeric()
                    ->step(0.01),
                Forms\Components\TextInput::make('parcelas_restantes')
                    ->label('Parcelas Restantes')
                    ->required()
                    ->integer()
                    ->rule('min:1'),
                Forms\Components\Select::make('cartao_id')
                    ->label('Cartão')
                    ->relationship('cartao', 'nome'),
                Forms\Components\Select::make('pessoa_id')
                    ->label('Pessoa')
                    ->relationship('pessoa', 'nome')
                    ->default(1),
                Forms\Components\TextInput::make('data_inicio')
                    ->label('Data Início (MM/AAAA)')
                    ->placeholder('MM/AAAA')
                    ->maxLength(7)
                    ->default(now()->format('m-Y')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
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
                    ->label('Data Inicio')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
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
                ->placeholder('Selecione um cartão')

            ], layout: FiltersLayout::AboveContent)
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListDividas::route('/'),
            'create' => Pages\CreateDivida::route('/create'),
            'edit' => Pages\EditDivida::route('/{record}/edit'),
        ];
    }


}
