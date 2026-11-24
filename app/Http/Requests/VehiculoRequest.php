<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VehiculoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $vehiculo = $this->user()->repartidor?->vehiculos()->first();

        return [
            'id_zona'       => ['required', 'integer', 'exists:zonas,id_zona'],
            'placa'         => [
                'required',
                'string',
                'max:15',
                Rule::unique('vehiculos', 'placa')->ignore($vehiculo?->id_vehiculo, 'id_vehiculo'),
            ],
            'marca'         => ['nullable', 'string', 'max:50'],
            'modelo'        => ['nullable', 'string', 'max:50'],
            'tipo_vehiculo' => ['required', Rule::in(['carro', 'moto', 'camioneta'])],
        ];
    }
}