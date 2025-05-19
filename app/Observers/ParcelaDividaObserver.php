<?php

namespace App\Observers;

use App\Models\ParcelaDivida;
use App\Models\Divida; // Importe o model Divida
use Illuminate\Support\Facades\DB;

class ParcelaDividaObserver
{
    /**
     * Handle the ParcelasDivida "updated" event.
     * Este método será chamado quando uma parcela for atualizada.
     */
    public function updated(ParcelaDivida $parcelaDivida): void
    {
        $parcelasRestantes = ParcelaDivida::where('divida_id', $parcelaDivida->divida_id)
            ->whereIn('status_id', [1,3])
            ->count();

        DB::table('dividas')
            ->where('id', $parcelaDivida->divida_id)
            ->update(['parcelas_restantes' => $parcelasRestantes]);
    }
}

