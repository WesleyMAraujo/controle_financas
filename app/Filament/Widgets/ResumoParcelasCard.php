<?php
namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\Pessoa;
use Illuminate\Contracts\View\View;
use App\Constants\CartaoContant;

class ResumoParcelasCard extends Widget
{
    protected static string $view = 'filament.widgets.resumo-parcelas'; // Defina a view que será renderizada

    // Certifique-se de que a assinatura do render está compatível
    public function render(): View
    {
        // Obtenha os dados necessários
        $pessoas = Pessoa::all();

        return view('filament.widgets.resumo-parcelas', [
            'pessoas' => $pessoas,
        ]);
    }
}

