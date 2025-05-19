<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use App\Models\ParcelaDivida;
use App\Constants\StatusConstant;

class Pessoa extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['nome', 'salario'];

    public function dividaTotalMes()
    {
        return $this->somaParcelasMes();
    }

    public function dividaTotalCartoes()
    {
        return $this->somaParcelasMes(null, true);
    }

    public function dividaTotalMesPago()
    {
        return $this->somaParcelasMes(StatusConstant::PAGO);
    }

    public function dividaTotalMesReservado()
    {
        return $this->somaParcelasMes(StatusConstant::RESERVADO);
    }

    public function dividaTotalMesRestante()
    {
        return $this->somaParcelasMes(StatusConstant::PAGAR);
    }

    public function dividaTotal()
    {
        return $this->divida()
            ->where('parcelas_restantes', '>', 0)
            ->sum('valor_parcela');
    }

    protected function somaParcelasMes($status = null, $cartao = false)
    {
        $mesAtual = Carbon::now()->format('m-Y');

        $query = ParcelaDivida::where('parcela', $mesAtual)
            ->join('dividas', 'parcelas_dividas.divida_id', '=', 'dividas.id')
            ->where('pessoa_id', $this->id);


        if (!is_null($status)) {
            $query->where('status_id', $status);
        }

        if ($cartao) {
            return $query->select('dividas.cartao_id')
            ->selectRaw('SUM(valor_parcela) as total')
            ->groupBy('dividas.cartao_id')
            ->pluck('total', 'dividas.cartao_id');
        }

        return $query->sum('valor_parcela');
    }
}
