<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePedidoOpcion extends Model
{
    use HasFactory;

    protected $table = 'detalle_pedido_opciones';
    protected $primaryKey = null;
    public $incrementing = false;

    protected $fillable = [
        'id_detalle',
        'id_opcion',
        'nombre_opcion',
        'precio_adicional',
    ];

    protected function casts(): array
    {
        return [
            'precio_adicional' => 'decimal:2',
        ];
    }

    // --- Relaciones ---

    public function detallePedido()
    {
        return $this->belongsTo(DetallePedido::class, 'id_detalle', 'id_detalle');
    }

    public function opcionProducto()
    {
        return $this->belongsTo(OpcionProducto::class, 'id_opcion', 'id_opcion');
    }
}