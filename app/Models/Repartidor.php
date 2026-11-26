<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Repartidor extends Model
{
    protected $table = 'repartidores';
    protected $primaryKey = 'id_repartidor';

        protected $fillable = [
        'id_usuario',
        'id_zona',
        'dni',
        'fecha_nacimiento',
        'foto_dni',
        'foto_licencia',
        'estado',
        'latitud_actual',
        'longitud_actual',
        'ultima_actualizacion',
        'estado_aprobacion',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id_usuario');
    }

    public function zona()
    {
        return $this->belongsTo(Zona::class, 'id_zona', 'id_zona');
    }

    public function vehiculos()
    {
        return $this->hasMany(Vehiculo::class, 'id_repartidor', 'id_repartidor');
    }
}