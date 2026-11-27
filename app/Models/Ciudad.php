<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{
    protected $table = 'ciudades';
    protected $primaryKey = 'id_ciudad';
    protected $fillable = ['nombre', 'activo'];

    public function getRouteKeyName(): string
    {
        return $this->primaryKey;
    }

    public function zonas()
    {
        return $this->hasMany(Zona::class, 'id_ciudad', 'id_ciudad');
    }
} 