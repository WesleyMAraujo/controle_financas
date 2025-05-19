<?php

namespace App\Filament\Resources\ParcelaDividaResource\Config;

use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\RestoreAction;
use Illuminate\Database\Eloquent\Collection;
use App\Models\ParcelaDivida;

class ActionsConfig {
    public static function getActions(): array
    {
        return [
            ActionGroup::make([
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
                    ->color('warning')
                    ->icon('heroicon-o-banknotes')
                    ->requiresConfirmation()
                    ->action(function (ParcelaDivida $record) {
                        $record->status_id = 3; // Assume que 3 é o ID para "Reservado"
                        $record->save();
                    }),

                Action::make('Cancelar Pagamento')
                    ->label('Cancelar Pagamento')
                    ->color('danger')
                    ->icon('heroicon-o-archive-box-x-mark')
                    ->requiresConfirmation()
                    ->action(function (ParcelaDivida $record) {
                        $record->status_id = 1; // Assume que 1 é o ID para "À Pagar"
                        $record->save();
                    }),

                EditAction::make(),
                DeleteAction::make(),
                ForceDeleteAction::make(),
                RestoreAction::make(),
            ]),
        ];
    }

    public static function getBulkActions(): array
    {
        return [
            DeleteBulkAction::make(),

            BulkAction::make('pagar')
                ->label('Pagar')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->action(fn (Collection $records) => $records->each(function ($record) {
                    $record->update(['status_id' => 2]); // 2 = Pago
                })),

            BulkAction::make('reservar')
                ->label('Reservar')
                ->icon('heroicon-o-banknotes')
                ->color('warning')
                ->requiresConfirmation()
                ->action(fn (Collection $records) => $records->each(function ($record) {
                    $record->update(['status_id' => 3]); // 3 = Reservado
                })),
            BulkAction::make('cancelar_pagamentos')
                ->label('Cancelar Pagamentos')
                ->icon('heroicon-o-archive-box-x-mark')
                ->color('danger')
                ->requiresConfirmation()
                ->action(fn (Collection $records) => $records->each(function ($record) {
                    $record->update(['status_id' => 1]); // 3 = Reservado
                })),
        ];
    }
}
