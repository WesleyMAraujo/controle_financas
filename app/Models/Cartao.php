<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cartao extends Model
{
    use SoftDeletes;

    protected $table = 'cartoes';

    protected $fillable = [
        'nome',
        'dia_vencimento',
        'dia_fechamento',
        'limite'
    ];

    public function dividas()
    {
        return $this->hasMany(Divida::class);
    }
}
