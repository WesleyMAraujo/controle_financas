<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CartaoResource\Pages;
use App\Models\Cartao;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Resources\CartaoResource\Config\FormConfig;
use App\Filament\Resources\CartaoResource\Config\FiltersConfig;
use App\Filament\Resources\CartaoResource\Config\TableConfig;

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
        return $form->schema(FormConfig::schema());
    }

    public static function table(Table $table): Table //Tabela para listar os cartões
    {
        return $table
            ->columns(TableConfig::getColumns())
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
