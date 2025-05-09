<?php
namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\Pessoa;
use Illuminate\Contracts\View\View;

class ResumoParcelasCard extends Widget
{
    protected static string $view = 'filament.widgets.resumo-parcelas'; // Defina a view que será renderizada

    // Certifique-se de que a assinatura do render está compatível
    public function render(): View
    {
        // Obtenha os dados necessários
        $pessoas = Pessoa::all();

        // Retorne a view com os dados
        return view('filament.widgets.resumo-parcelas', [
            'pessoas' => $pessoas,
        ]);
    }
}

