<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ParcelaDivida extends Model
{
    use SoftDeletes;

    protected $table = 'parcelas_dividas'; // Adiciona esta linha para definir o nome da tabela

    protected $fillable = [
        'divida_id',
        'status_id',
        'parcela',
    ];

    // ParcelaDivida.php

    public function divida()
    {
        return $this->belongsTo(Divida::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
