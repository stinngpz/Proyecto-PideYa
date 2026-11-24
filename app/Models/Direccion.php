<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    protected $table = 'direcciones';
    protected $primaryKey = 'id_direccion';

    protected $fillable = [
        'id_zona',
        'nombre',
        'latitud_envio',
        'longitud_envio',
        'detalle_calle',
        'referencia',
        'es_predeterminada',
    ];

    protected function casts(): array
    {
        return [
            'latitud_envio' => 'float',
            'longitud_envio' => 'float',
            'es_predeterminada' => 'boolean',
        ];
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id_usuario');
    }

    public function zona()
    {
        return $this->belongsTo(Zona::class, 'id_zona', 'id_zona');
    }
}