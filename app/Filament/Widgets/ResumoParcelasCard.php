<?php
namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\Pessoa;
use Illuminate\Contracts\View\View;
use App\Constants\CartaoContant;
use App\Models\ParcelaDivida;
use Carbon\Carbon;

class ResumoParcelasCard extends Widget
{
    protected static string $view = 'filament.widgets.resumo-parcelas';

    public function render(): View
    {
        $mesAtualAnoAtual = Carbon::now()->format('m-Y');

        $resumoPorStatus = ParcelaDivida::where('parcela', $mesAtualAnoAtual)
            ->join('dividas', 'parcelas_dividas.divida_id', '=', 'dividas.id') // Join the 'dividas' table
            ->selectRaw('parcelas_dividas.status_id, count(*) as total_parcelas, SUM(dividas.valor_parcela) as soma_valor_parcelas') // Sum from the 'dividas' table
            ->groupBy('parcelas_dividas.status_id')
            ->get();

        return view('filament.widgets.resumo-parcelas', [
            'resumoPorStatus' => $resumoPorStatus,
        ]);
    }
}

