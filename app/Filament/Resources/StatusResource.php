<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StatusResource\Pages;
use App\Filament\Resources\StatusResource\RelationManagers;
use App\Models\Status;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\ColorPicker;

class StatusResource extends Resource
{
    // Associate the model with this resource
    protected static ?string $model = Status::class;

    // Set the navigation icon for the sidebar
    protected static ?string $navigationIcon = 'heroicon-o-tag'; // Choose an appropriate icon

    // Set the navigation group (optional)
    protected static ?string $navigationGroup = 'Configurações'; // Example group

    // Set the navigation sort order (optional)
    protected static ?int $navigationSort = 1; // Example sort order

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nome') // Your status name column
                    ->label('Nome do Status')
                    ->required()
                    ->maxLength(255),
                ColorPicker::make('color') // Make sure 'color' matches your column name
                    ->label('Cor do Status') // Label for the form field
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nome') // Your status name column
                    ->label('Nome')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\ColorColumn::make('color')
                    ->label('Cor'),
            ])
            ->filters([
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStatuses::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class, // Remove this if you don't use soft deletes
            ]);
    }
}
