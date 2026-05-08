<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $validateName = function ($attribute, $value, $fail) {
            $fieldNames = [
                'name' => 'nombre',
                'apellido_paterno' => 'apellido paterno',
                'apellido_materno' => 'apellido materno'
            ];
            $fieldName = $fieldNames[$attribute] ?? str_replace('_', ' ', $attribute);
            
            if (!preg_match('/^[a-zA-Z\s\p{L}]+$/u', $value)) {
                $fail('El ' . $fieldName . ' solo puede contener letras y espacios.');
            }
        };

        $validateDifferentNames = function ($attribute, $value, $fail) {
            $val = strtolower(trim($value));
            $others = [];
            if ($attribute !== 'name') $others['nombre'] = strtolower(trim($this->input('name')));
            if ($attribute !== 'apellido_paterno') $others['apellido paterno'] = strtolower(trim($this->input('apellido_paterno')));
            if ($attribute !== 'apellido_materno') $others['apellido materno'] = strtolower(trim($this->input('apellido_materno')));
            
            foreach ($others as $otherName => $otherVal) {
                if ($val && $val === $otherVal) {
                    $fieldName = str_replace('_', ' ', $attribute);
                    if ($fieldName === 'name') $fieldName = 'nombre';
                    $fail('El ' . $fieldName . ' no puede ser igual al ' . $otherName . '.');
                }
            }
        };

        return [
            'name' => ['required', 'string', 'max:50', $validateName, $validateDifferentNames],
            'apellido_paterno' => ['required', 'string', 'max:50', $validateName, $validateDifferentNames],
            'apellido_materno' => ['required', 'string', 'max:50', $validateName, $validateDifferentNames],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
                function ($attribute, $value, $fail) {
                    if (!str_ends_with(strtolower($value), '@gmail.com')) {
                        $fail('El correo electrónico debe ser una cuenta de Gmail (@gmail.com).');
                    }
                }
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'name.max' => 'El nombre no puede exceder 50 caracteres.',
            'apellido_paterno.required' => 'El apellido paterno es obligatorio.',
            'apellido_paterno.max' => 'El apellido paterno no puede exceder 50 caracteres.',
            'apellido_materno.required' => 'El apellido materno es obligatorio.',
            'apellido_materno.max' => 'El apellido materno no puede exceder 50 caracteres.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser válido.',
            'email.max' => 'El correo electrónico no puede exceder 255 caracteres.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
        ];
    }
}
