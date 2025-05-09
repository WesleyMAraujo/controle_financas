<?php

namespace App\Observers;

use App\Models\Divida;
use App\Models\ParcelaDivida;
use Carbon\Carbon;

class DividaObserver
{
    /**
     * Handle the Divida created event.
     */
    public function created(Divida $divida): void
    {
        $dataInicio = Carbon::createFromFormat('m-Y', $divida->data_inicio)->startOfMonth();

        $parcelasRestantes = $divida->parcelas_restantes;
        $statusId = 1; // Defina o status_id padrão, por exemplo, 1 para "À Pagar"

        for ($i = 0; $i < $parcelasRestantes; $i++) {
            ParcelaDivida::create([
                'divida_id' => $divida->id,
                'status_id' => $statusId,
                'parcela' => $dataInicio->format('m-Y'),
            ]);

            $dataInicio->addMonth();
        }
    }

    public function updated(Divida $divida): void
    {
        ParcelaDivida::where('divida_id', $divida->id)->delete();

        $dataInicio = Carbon::createFromFormat('m-Y', $divida->data_inicio)->startOfMonth();

        $parcelasRestantes = $divida->parcelas_restantes;
        $statusId = 1; // Defina o status_id padrão, por exemplo, 1 para "À Pagar"

        for ($i = 0; $i < $parcelasRestantes; $i++) {
            ParcelaDivida::create([
                'divida_id' => $divida->id,
                'status_id' => $statusId,
                'parcela' => $dataInicio->format('m-Y'),
            ]);

            $dataInicio->addMonth();
        }
    }

    public function deleted(Divida $divida): void
    {
        ParcelaDivida::where('divida_id', $divida->id)->delete();
    }
}
