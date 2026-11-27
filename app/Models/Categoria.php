<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categorias';
    protected $primaryKey = 'id_categoria';

    protected $fillable = [
        'id_departamento',
        'nombre',
        'orden',
    ];

    public function getRouteKeyName(): string
    {
        return $this->primaryKey;
    }

    // --- Relaciones ---

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'id_departamento', 'id_departamento');
    }

    public function productos()
    {
        return $this->hasMany(Producto::class, 'id_categoria', 'id_categoria');
    }
}