<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PessoaResource\Pages;
use App\Models\Pessoa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Resources\PessoaResource\Config\TableConfig;
use App\Filament\Resources\PessoaResource\Config\FormConfig;
use App\Filament\Resources\PessoaResource\Config\ActionsConfig;

class PessoaResource extends Resource
{
    protected static ?string $model = Pessoa::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function form(Form $form): Form
    {
        return $form->schema(FormConfig::schema());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(TableConfig::getColumns())
            ->searchable()
            ->filters([
                Tables\Filters\TrashedFilter::make()
            ])
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
            'index' => Pages\ListPessoas::route('/'),
            // 'create' => Pages\CreatePessoa::route('/create'),
            // 'edit' => Pages\EditPessoa::route('/{record}/edit'),
        ];
    }
}
