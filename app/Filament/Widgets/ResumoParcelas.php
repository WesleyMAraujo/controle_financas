<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\ParcelaDivida;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Filament\Support\Html;
use App\Models\Pessoa;
use Filament\Support\Markdown;

class ResumoParcelas extends BaseWidget
{
    protected function getStats(): array
    {
        $mesAtual = Carbon::now(); // ou qualquer data que você queira manipular
        $mesAtual = $mesAtual->format('m-Y');

        $contasPagasNoMes = ParcelaDivida::where('parcela', $mesAtual)->where('status_id', 2)->get();

        $totalPagoMes = 0.00;
        foreach ($contasPagasNoMes as $parcela) {
            $totalPagoMes += $parcela->divida->valor_parcela;
        }

        $contasEmAbertoNoMes = ParcelaDivida::where('parcela', $mesAtual)->whereIn('status_id', [1,3])->get();

        $totalPendenteMes = 0.00;
        foreach ($contasEmAbertoNoMes as $parcela) {
            $totalPendenteMes += $parcela->divida->valor_parcela;
        }

        $pessoas = Pessoa::all();


        $contasPagasNoMes = $contasPagasNoMes->count();
        $contasEmAbertoNoMes = $contasEmAbertoNoMes->count();



        $stats = [
            Stat::make("Pagas Este Mês", $contasPagasNoMes)
                ->description("Total: $totalPagoMes")
                ->color('success')
                ->icon('heroicon-o-check-circle'),

            Stat::make("Em Aberto Este Mês", $contasEmAbertoNoMes)
                ->description("Total: $totalPendenteMes")
                ->color('danger')
                ->icon('heroicon-o-exclamation-circle'),
        ];

        // // Adiciona dinamicamente os stats por pessoa
        // foreach ($pessoas as $pessoa) {
        //     $stats[] = Stat::make("Pessoa: {$pessoa->nome}", $pessoa->total)
        //         ->description("")

        //         ->color('info')
        //         ->icon('heroicon-o-user');
        // }

        return $stats;
    }
}
