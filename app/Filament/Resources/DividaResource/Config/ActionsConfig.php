<?php

namespace App\Filament\Resources\DividaResource\Config;

use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\Action; // Importe a classe Action
use Carbon\Carbon; // Importe a classe Carbon para trabalhar com datas
use App\Constants\StatusConstant;

class ActionsConfig {
    public static function getActions(): array
    {
        return [
            ActionGroup::make([
                EditAction::make(),
                DeleteAction::make(),
                ForceDeleteAction::make(),
                RestoreAction::make(),
                Action::make('adiantar-parcelas')
                    ->label('Adiantar Parcelas')
                    ->icon('heroicon-o-currency-dollar')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalIcon('heroicon-o-check-circle')
                    ->modalHeading('Confirmar Adiantamento')
                    ->modalDescription('Tem certeza que deseja adiantar esta parcela para o mês atual?')
                    ->action(function ($record) {
                        $ultimaParcela = $record->parcela()->where('status_id', StatusConstant::PAGAR)
                            ->latest('parcela')
                            ->first();

                        $parelasRestantes = $record->parcela()->where('status_id', StatusConstant::PAGAR)
                            ->latest('parcela')
                            ->count();

                        if($parelasRestantes > 1)
                        {
                            $mesAtualAnoAtual = Carbon::now()->format('m-Y');

                            $ultimaParcela->parcela = $mesAtualAnoAtual;
                            $ultimaParcela->save();

                            \Filament\Notifications\Notification::make()
                                ->title('Parcelas adiantadas!')
                                ->body("As parcelas da dívida '{$record->nome_da_divida}' foram adiantadas.")
                                ->success()
                                ->send();
                        }

                        \Filament\Notifications\Notification::make()
                            ->title('Erro!')
                            ->body("Não existem parcelas para serem adiantadas")
                            ->danger()
                            ->send();


                    }),
            ]),
        ];
    }

    public static function getBulkActions(): array
    {
        return [
            DeleteBulkAction::make(),
        ];
    }
}
