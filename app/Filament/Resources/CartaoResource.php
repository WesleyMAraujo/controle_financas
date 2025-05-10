<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CartaoResource\Pages;
use App\Filament\Resources\CartaoResource\RelationManagers;
use App\Models\Cartao;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CartaoResource extends Resource
{
    protected static ?string $model = Cartao::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $label = 'Cartões'; 

    // Caso prefira usar o método getLabel
    public static function getLabel(): string
    {
        return 'Cartões';
    }

    public static function getPluralLabel(): string
    {
        return 'Cartões';
    }

    public static function form(Form $form): Form //Formulário para criar e editar cartões
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nome')
                    ->label('Nome') // Rótulo do campo
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('limite')
                    ->label('Limite') // Rótulo do campo
                    ->numeric() // Mantém como numérico
                    ->step(0.01) // Especifica o intervalo de incremento como 0.01 (para 2 casas decimais)
                    ->minValue(0),
                Forms\Components\TextInput::make('dia_vencimento')
                    ->label('Dia de Vencimento') // Rótulo do campo
                    ->integer() // Define o campo como inteiro
                    ->rule('min:1')       // Define o valor mínimo usando rule
                    ->rule('max:31'),     // Define o valor máximo usando rule
            ]);
    }

    public static function table(Table $table): Table //Tabela para listar os cartões
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id') // Adiciona a coluna 'id'
                    ->label('ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('nome')
                    ->label('Nome') // Rótulo da coluna
                    ->searchable(),
                Tables\Columns\TextColumn::make('limite')
                    ->label('Limite') // Rótulo da coluna
                    ->searchable(),
                Tables\Columns\TextColumn::make('dia_vencimento')
                    ->label('Dia de Vencimento') // Rótulo da coluna
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
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
            'index' => Pages\ListCartaos::route('/'),
            'create' => Pages\CreateCartao::route('/create'),
            'edit' => Pages\EditCartao::route('/{record}/edit'),
        ];
    }
}
