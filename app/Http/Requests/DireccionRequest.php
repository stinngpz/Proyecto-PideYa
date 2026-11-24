<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DireccionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre'            => ['required', 'string', 'max:60'],
            'id_zona'           => ['required', 'integer', 'exists:zonas,id_zona'],
            'latitud_envio'     => ['required', 'numeric', 'between:12.9,16.6'],
            'longitud_envio'    => ['required', 'numeric', 'between:-89.5,-83.0'],
            'detalle_calle'     => ['required', 'string', 'max:255'],
            'referencia'        => ['required', 'string', 'max:250'],
            'es_predeterminada' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'latitud_envio.required'  => 'Marca tu ubicación en el mapa.',
            'latitud_envio.between'   => 'La ubicación debe estar dentro de Honduras.',
            'longitud_envio.between'  => 'La ubicación debe estar dentro de Honduras.',
        ];
    }
}