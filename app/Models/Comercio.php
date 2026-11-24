<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comercio extends Model
{
    protected $table = 'comercios';
    protected $primaryKey = 'id_comercio';

    protected $fillable = [
        'id_usuario',
        'id_tipo_comercio',
        'nombre',
        'rtn',
        'descripcion',
        'logo',
        'banner',
        'tiempo_promedio_min',
        'costo_delivery_base',
        'porcentaje_comision',
        'estado_aprobacion',
        'esta_activado',
        'calificacion',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id_usuario');
    }

    public function tipo()
    {
        return $this->belongsTo(TipoComercio::class, 'id_tipo_comercio', 'id_tipo_comercio');
    }

    public function sucursales()
    {
        return $this->hasMany(Sucursal::class, 'id_comercio', 'id_comercio');
    }
}