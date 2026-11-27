<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedidos';
    protected $primaryKey = 'id_pedido';

    protected $fillable = [
        'id_cliente',
        'id_comercio',
        'id_sucursal',
        'id_direccion',
        'id_estado',
        'latitud_entrega',
        'longitud_entrega',
        'direccion_entrega',
        'instrucciones_entrega',
        'distancia_km',
        'subtotal',
        'tarifa_envio',
        'pago_repartidor',
        'descuento',
        'base_gravada',
        'isv',
        'propina',
        'total',
        'eta_minutos',
        'motivo_cancelacion',
        'fecha_creacion',
        'fecha_entrega',
    ];

    protected function casts(): array
    {
        return [
            'latitud_entrega' => 'decimal:7',
            'longitud_entrega' => 'decimal:7',
            'distancia_km' => 'decimal:2',
            'subtotal' => 'decimal:2',
            'tarifa_envio' => 'decimal:2',
            'pago_repartidor' => 'decimal:2',
            'descuento' => 'decimal:2',
            'base_gravada' => 'decimal:2',
            'isv' => 'decimal:2',
            'propina' => 'decimal:2',
            'total' => 'decimal:2',
            'eta_minutos' => 'integer',
            'fecha_creacion' => 'datetime',
            'fecha_entrega' => 'datetime',
        ];
    }

    public function getRouteKeyName(): string
    {
        return $this->primaryKey;
    }

    // --- Relaciones ---

    public function cliente()
    {
        return $this->belongsTo(User::class, 'id_cliente', 'id_usuario');
    }

    public function comercio()
    {
        return $this->belongsTo(Comercio::class, 'id_comercio', 'id_comercio');
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'id_sucursal', 'id_sucursal');
    }

    public function direccion()
    {
        return $this->belongsTo(Direccion::class, 'id_direccion', 'id_direccion');
    }

    public function estado()
    {
        return $this->belongsTo(EstadoPedido::class, 'id_estado', 'id_estado');
    }

    public function detalles()
    {
        return $this->hasMany(DetallePedido::class, 'id_pedido', 'id_pedido');
    }

    public function historialEstados()
    {
        return $this->hasMany(HistorialEstado::class, 'id_pedido', 'id_pedido');
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'id_pedido', 'id_pedido');
    }

    public function comision()
    {
        return $this->hasOne(Comision::class, 'id_pedido', 'id_pedido');
    }

    public function facturas()
    {
        return $this->hasMany(Factura::class, 'id_pedido', 'id_pedido');
    }

    public function asignaciones()
    {
        return $this->hasMany(AsignacionPedido::class, 'id_pedido', 'id_pedido');
    }
}