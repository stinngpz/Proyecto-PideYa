<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComercioProducto extends Model
{
    use HasFactory;

    protected $table = 'comercio_productos';
    protected $primaryKey = 'id_comercio_producto';

    protected $fillable = [
        'id_comercio',
        'id_producto',
        'precio',
        'foto',
        'esta_disponible',
        'stock',
    ];

    public function getRouteKeyName(): string
    {
        return $this->primaryKey;
    }

    // --- Relaciones ---

    public function comercio()
    {
        return $this->belongsTo(Comercio::class, 'id_comercio', 'id_comercio');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto', 'id_producto');
    }

    public function detallesPedido()
    {
        return $this->hasMany(DetallePedido::class, 'id_comercio_producto', 'id_comercio_producto');
    }
}