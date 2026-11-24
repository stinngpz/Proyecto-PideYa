<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegistroRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $esComercio = $this->input('rol') === 'comercio';

        return [
            'nombre'           => ['required', 'string', 'max:80'],
            'apellido'         => ['required', 'string', 'max:80'],
            'correo'           => ['required', 'email', 'max:150', 'unique:usuarios,correo'],
            'telefono'         => ['required', 'digits:8'],
            'password'         => ['required', 'string', 'min:8', 'confirmed'],
            'rol'              => ['required', Rule::in(['cliente', 'comercio', 'repartidor'])],
            'nombre_negocio'   => [Rule::requiredIf($esComercio), 'nullable', 'string', 'max:120'],
            'rtn'              => [Rule::requiredIf($esComercio), 'nullable', 'digits:14'],
            'id_tipo_comercio' => [Rule::requiredIf($esComercio), 'nullable', 'integer', 'exists:tipos_comercio,id_tipo_comercio'],
            'descripcion'      => [Rule::requiredIf($esComercio), 'nullable', 'string', 'max:500'],
        ];
    }
}