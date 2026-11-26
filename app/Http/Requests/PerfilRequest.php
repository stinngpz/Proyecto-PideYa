<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PerfilRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre' => ['sometimes', 'required', 'string', 'max:80'],
            'apellido' => ['sometimes', 'required', 'string', 'max:80'],
            'telefono' => ['sometimes', 'required', 'digits:8'],
            // RTN hondureño: 14 dígitos. Es opcional, solo se necesita para la factura SAR
            'rtn_para_sar' => ['sometimes', 'nullable', 'digits:14'],
            'correo' => ['sometimes', 'required', 'email', 'max:150', Rule::unique('usuarios', 'correo')->ignore($this->user()->id_usuario, 'id_usuario')],
            'password_actual' => [Rule::requiredIf($this->has('correo') && $this->input('correo') != $this->user()->correo), 'nullable', 'current_password'],
        ];
    }

    public function messages(): array
    {
        return [
            'password_actual.required' => 'Escribe tu contraseña actual para cambiar el correo.',
            'password_actual.current_password' => 'La contraseña actual no es correcta.',
            'correo.unique' => 'Ese correo ya lo usa otra cuenta.',
        ];
    }
}
