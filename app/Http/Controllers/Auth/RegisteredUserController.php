<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Custom validation function for names (letters and spaces only)
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

        // Custom validation function for password complexity
        $validatePassword = function ($attribute, $value, $fail) {
            $hasLetter = preg_match('/[a-zA-Z\p{L}]/u', $value);
            $hasNumber = preg_match('/\d/', $value);
            $specialChars = '!@#$%^&*()_+-=[]{};\'",./<>?|\\';
            $hasSpecial = false;
            foreach (str_split($specialChars) as $char) {
                if (strpos($value, $char) !== false) {
                    $hasSpecial = true;
                    break;
                }
            }
            
            if (!$hasLetter || !$hasNumber || !$hasSpecial) {
                $fail('La contraseña debe contener letras, números y caracteres especiales.');
            }
        };

        // Custom validation to ensure the three name fields are not all equal
        $validateDifferentNames = function ($attribute, $value, $fail) use ($request) {
            $name = strtolower(trim($request->input('name')));
            $apellido_paterno = strtolower(trim($request->input('apellido_paterno')));
            $apellido_materno = strtolower(trim($request->input('apellido_materno')));
            
            if ($name && $apellido_paterno && $apellido_materno) {
                if ($name === $apellido_paterno && $apellido_paterno === $apellido_materno) {
                    $fail('El nombre, apellido paterno y apellido materno no pueden ser idénticos.');
                }
            }
        };

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:50',
                $validateName
            ],
            'apellido_paterno' => [
                'required',
                'string',
                'max:50',
                $validateName
            ],
            'apellido_materno' => [
                'required',
                'string',
                'max:50',
                $validateName,
                $validateDifferentNames
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:'.User::class,
                function ($attribute, $value, $fail) {
                    if (!str_ends_with(strtolower($value), '@gmail.com')) {
                        $fail('El correo electrónico debe ser una cuenta de Gmail (@gmail.com).');
                    }
                }
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'max:255',
                $validatePassword
            ],
            'password_confirmation' => ['required', 'same:password'],
        ], [
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
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.max' => 'La contraseña no puede exceder 255 caracteres.',
            'password_confirmation.required' => 'Debe confirmar la contraseña.',
            'password_confirmation.same' => 'Las contraseñas no coinciden.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'apellido_paterno' => $request->apellido_paterno,
            'apellido_materno' => $request->apellido_materno,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('client.home', absolute: false));
    }
}
