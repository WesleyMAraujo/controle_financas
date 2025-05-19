<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Divida extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nome',
        'cartao_id',
        'valor_parcela',
        'valor_total',
        'parcelas_restantes',
        'data_inicio',
    ];

    public function cartao()
    {
        return $this->belongsTo(Cartao::class, 'cartao_id');
    }

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'pessoa_id');
    }

    public function parcela()
    {
        return $this->belongsTo(ParcelaDivida::class, 'id', 'divida_id');
    }

    // Divida.php
    public function parcelaDividas()
    {
        return $this->hasMany(ParcelaDivida::class);
    }

}
