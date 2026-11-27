<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    use HasFactory;

    protected $table = 'departamentos';
    protected $primaryKey = 'id_departamento';

    protected $fillable = [
        'nombre',
        'icono',
        'orden',
        'activo',
    ];

    public function getRouteKeyName(): string
    {
        return $this->primaryKey;
    }

    // --- Relaciones ---

    public function categorias()
    {
        return $this->hasMany(Categoria::class, 'id_departamento', 'id_departamento');
    }
