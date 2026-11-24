<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SucursalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre'    => ['required', 'string', 'max:120'],
            'id_zona'   => ['required', 'integer', 'exists:zonas,id_zona'],
            'direccion' => ['required', 'string', 'max:255'],
            'telefono'  => ['required', 'digits:8'],
            'latitud'   => ['required', 'numeric', 'between:12.9,16.6'],
            'longitud'  => ['required', 'numeric', 'between:-89.5,-83.0'],
        ];
    }

    public function messages(): array
    {
        return [
            'latitud.required' => 'Marca la ubicación de la sucursal en el mapa.',
            'latitud.between'  => 'La ubicación debe estar dentro de Honduras.',
            'longitud.between' => 'La ubicación debe estar dentro de Honduras.',
        ];
    }
}