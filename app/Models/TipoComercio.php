<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoComercio extends Model
{
    protected $table = 'tipos_comercio';
    protected $primaryKey = 'id_tipo_comercio';
    protected $fillable = ['nombre', 'icono'];
}