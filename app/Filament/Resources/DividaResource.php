<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DividaResource\Pages;
use App\Models\Divida;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Resources\DividaResource\Config\FormConfig;
use App\Filament\Resources\DividaResource\Config\FiltersConfig;
use App\Filament\Resources\DividaResource\Config\TableConfig;

class DividaResource extends Resource
{
    protected static ?string $model = Divida::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    public static function form(Form $form): Form
    {
        return $form->schema(FormConfig::schema());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(TableConfig::getColumns())
            ->filters(FiltersConfig::getFilters())
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
