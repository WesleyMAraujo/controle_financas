<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ParcelaDividaResource\Pages;
use App\Models\ParcelaDivida;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\ActionGroup;
use Illuminate\Support\Collection;
use App\Filament\Resources\ParcelaDividaResource\Config\FiltersConfig;
use App\Filament\Resources\ParcelaDividaResource\Config\FormConfig;
use App\Filament\Resources\ParcelaDividaResource\Config\TableConfig;
use App\Filament\Resources\ParcelaDividaResource\Config\ActionsConfig;

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
        return $form->schema(FormConfig::schema());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(TableConfig::getColumns())
            ->filters(FiltersConfig::getFilters(), layout: FiltersLayout::AboveContent)
            ->actions(ActionsConfig::getActions())
            ->bulkActions(ActionsConfig::getBulkActions());
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
            // 'create' => Pages\CreateParcelaDivida::route('/create'),
            // 'edit' => Pages\EditParcelaDivida::route('/{record}/edit'),
        ];
    }
}
