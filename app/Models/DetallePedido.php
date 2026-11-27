<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePedido extends Model
{
    use HasFactory;

    protected $table = 'detalle_pedido';
    protected $primaryKey = 'id_detalle';

    protected $fillable = [
        'id_pedido',
        'id_comercio',
        'id_comercio_producto',
        'id_oferta',
        'nombre_producto',
        'cantidad',
        'precio_normal',
        'precio_oferta',
        'subtotal_linea',
        'notas_comercio',
    ];

    protected function casts(): array
    {
        return [
            'cantidad' => 'integer',
            'precio_normal' => 'decimal:2',
            'precio_oferta' => 'decimal:2',
            'subtotal_linea' => 'decimal:2',
            'descuento_linea' => 'decimal:2',
        ];
    }

    public function getRouteKeyName(): string
    {
        return $this->primaryKey;
    }

    // --- Relaciones ---

    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'id_pedido', 'id_pedido');
    }

    public function comercio()
    {
        return $this->belongsTo(Comercio::class, 'id_comercio', 'id_comercio');
    }

    public function comercioProducto()
    {
        return $this->belongsTo(ComercioProducto::class, 'id_comercio_producto', 'id_comercio_producto');
    }

    public function oferta()
    {
        return $this->belongsTo(Oferta::class, 'id_oferta', 'id_oferta');
    }
}