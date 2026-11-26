<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SolicitudRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'dni'              => ['required', 'digits:13', 'unique:repartidores,dni'],
            'fecha_nacimiento' => ['required', 'date', 'before_or_equal:-18 years'],
            'id_zona'          => ['required', 'integer', 'exists:zonas,id_zona'],
            'tipo_vehiculo'    => ['required', Rule::in(['moto', 'carro', 'camioneta'])],
            'placa'            => ['required', 'string', 'max:15', 'unique:vehiculos,placa'],
            'marca'            => ['nullable', 'string', 'max:50'],
            'modelo'           => ['nullable', 'string', 'max:50'],
            'foto_dni'         => ['required', 'image', 'max:2048'],
            'foto_licencia'    => ['required', 'image', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'fecha_nacimiento.before_or_equal' => 'Debes ser mayor de 18 años para ser repartidor.',
        ];
    }
}
