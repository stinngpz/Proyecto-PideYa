<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comision extends Model
{
    protected $table = 'comisiones';
    protected $primaryKey = 'id_comision';

    protected $fillable = [
        'id_pedido',
        'porcentaje',
        'base_comision',
        'monto_comision',
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'id_pedido', 'id_pedido');
    }
}