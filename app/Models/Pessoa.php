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

    protected function somaParcelasMes($status = null)
    {
        $mesAtual = Carbon::now()->format('m-Y');

        $query = ParcelaDivida::where('parcela', $mesAtual)
            ->join('dividas', 'parcelas_dividas.divida_id', '=', 'dividas.id')
            ->where('pessoa_id', $this->id);


        if (!is_null($status)) {
            $query->where('status_id', $status);
        }

        return $query->sum('valor_parcela');
    }
}
