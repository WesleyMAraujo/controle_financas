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
use Illuminate\Support\Collection;
use App\Filament\Resources\ParcelaDividaResource\Config\FiltersConfig;
use App\Filament\Resources\ParcelaDividaResource\Config\FormConfig;
use App\Filament\Resources\ParcelaDividaResource\Config\TableConfig;

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
